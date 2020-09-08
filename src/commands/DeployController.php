<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use samdark\log\PsrMessage;
use whotrades\RdsBuildAgent\commands\Exception\StopBuildTask;
use whotrades\RdsBuildAgent\lib\PosixGroupManager;
use whotrades\RdsBuildAgent\services\DeployService;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\Exception\ScriptExecutorException;
use whotrades\RdsSystem\Model\Rabbit\MessagingRdsMs;
use Yii;
use whotrades\RdsSystem\Message;
use yii\base\Event;
use whotrades\RdsBuildAgent\services\DeployService\Event\DeployStatusEvent;

class DeployController extends RabbitListener
{

    /** @var MessagingRdsMs */
    private $model;

    /** @var DeployService */
    protected $deployService;

    /** @var PosixGroupManager */
    protected $posixGroupManager;

    public function __construct($id, $module, DeployService $deployService, PosixGroupManager $posixGroupManager, $config = [])
    {
        $this->deployService = $deployService;
        $this->posixGroupManager = $posixGroupManager;
        $this->model  = $this->getMessagingModel();
        $this->attachEvents();
        parent::__construct($id, $module, $config);
    }

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $this->model->getBuildTask($workerName, false, function (Message\BuildTask $task) use ($workerName) {
            Yii::info("Build task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $this->processTask($workerName, $task);
        });

        $this->model->getInstallTask($workerName, false, function (Message\InstallTask $task) use ($workerName) {
            Yii::info("Install task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $this->processTask($workerName, $task);
        });

        try {
            $this->waitForMessages($this->model);
        } catch (StopBuildTask $e) {
            $sigName = $this->mapSigNoToName($e->getSigno());
            \Yii::info("Tool was stopped with signal $sigName");
        }
    }

    /**
     * @param string $workerName
     * @param Message\DeployTaskBase $task
     */
    private function processTask(string $workerName, Message\DeployTaskBase $task)
    {
        try {
            $this->posixGroupManager->setCurrentPidAsGid();
            $this->createPidFiles($workerName, $task->id);
            switch (get_class($task)) {
                case Message\BuildTask::class:
                    $this->deployService->deployBuild($task);
                    break;
                case Message\InstallTask::class:
                    $this->deployService->deployInstall($task);
                    break;
                default:
                    Yii::info("Unknown task type " . get_class($task) . ", skipping.");
                    $task->accepted();
            }
        } catch (ScriptExecutorException $e) {
            $this->processCommandExecutorException($e, (int) $task->id, $task->version, DeployStatusEvent::TYPE_FAILED);
        } catch (StopBuildTask $e) {
            $sigName = $this->mapSigNoToName($e->getSigno());
            Yii::error(new PsrMessage("Stop processing task with signal {signal}", [
                'task_id' => $task->id,
                'version' => $task->version,
                'signal' => $sigName,
            ]));
            $this->sendStatus(DeployStatusEvent::TYPE_FAILED, $task->id, $task->version, "Processing of task was stopped with signal $sigName");
        } catch (\Exception $e) {
            Yii::error(new PsrMessage("Unknown error while executing task", [
                'task_id' => $task->id,
                'version' => $task->version,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]));
            $this->sendStatus(DeployStatusEvent::TYPE_FAILED, $task->id, $task->version, $e->getMessage());
        } finally {
            $this->posixGroupManager->restoreGid();
        }
    }

    /**
     * Attaches events for notifications
     */
    private function attachEvents()
    {
        Event::on(DeployService::class, DeployService::EVENT_DEPLOY_STATUS, function (DeployService\Event\DeployStatusEvent $event) {
            $this->model->sendTaskStatusChanged(
                new Message\TaskStatusChanged($event->getTaskId(), $event->getType(), $event->getVersion(), $event->getPayload())
            );
        });
        Event::on(DeployService::class, DeployService::EVENT_CRON_CONFIG_UPDATE, function (DeployService\Event\CronConfigUpdateEvent $event) {
            $this->model->sendCronConfig(new Message\ReleaseRequestCronConfig($event->getTaskId(), $event->getCronConfig()));
        });
    }

    /**
     * @param ScriptExecutorException $exception
     * @param int $taskId
     * @param string $version
     * @param string $sendStatus
     */
    private function processCommandExecutorException(ScriptExecutorException $exception, int $taskId, $version, $sendStatus)
    {
        Yii::error(new PsrMessage("Script failed to execute", [
            'version' => $version,
            'script' => $exception->getScript(),
        ]));
        $previous = $exception->getPrevious();

        $buildLog = $exception->getMessage();

        if ($previous instanceof CommandExecutorException) {
            $text = $previous->getOutput();
            $buildLog = "Failed to execute " . $previous->getCommand() . "\n";
            $buildLog .= "Command output " . $text . "\n";
        }

        $this->sendStatus($sendStatus, $taskId, $version, $buildLog);
    }

    /**
     * Отправляет на сервер текущий статус сборки на конкретной машине сборщике
     *
     * @param string $status
     * @param int $taskId
     * @param null $version
     * @param null $attach
     */
    private function sendStatus($status, int $taskId, $version = null, $attach = null)
    {
        Yii::info("Task status changed: id=$taskId, status=$status, version=$version, attach_length=" . strlen($attach));
        $this->model->sendTaskStatusChanged(
            new Message\TaskStatusChanged($taskId, $status, $version, $attach)
        );
    }

    /**
     * @param int $signo
     *
     * @throws StopBuildTask
     */
    public function onTerm($signo)
    {
        Yii::info("Caught signal " . $this->mapSigNoToName($signo));
        $this->stopReceivingMessages();

        throw new StopBuildTask($signo);
    }

    /**
     * @param string $workerName
     * @param int $taskId
     */
    private function createPidFiles(string $workerName, int $taskId): void
    {
        if (!file_exists(\Yii::$app->params['pidDir'])) {
            mkdir(\Yii::$app->params['pidDir'], 0777, true);
        }

        $basePidFilename = \Yii::$app->params['pidDir'] . "/{$workerName}_deploy_$taskId.php";
        $pid = $this->posixGroupManager->getCurrentPid();
        file_put_contents("$basePidFilename.pid", $pid);
        file_put_contents("$basePidFilename.pgid", $this->posixGroupManager->getCurrentGid());

        register_shutdown_function(function () use ($basePidFilename) {
            unlink("$basePidFilename.pid");
            unlink("$basePidFilename.pgid");
        });
    }
}
