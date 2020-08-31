<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsBuildAgent\commands\Exception\StopBuildTask;
use whotrades\RdsBuildAgent\lib\PosixGroupManager;
use whotrades\RdsBuildAgent\services\DeployService;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\Exception\ScriptExecutorException;
use Yii;
use whotrades\RdsSystem\Message;
use yii\base\Event;

class DeployController extends RabbitListener
{
    const MIGRATION_TYPE_PRE = 'pre';
    const MIGRATION_TYPE_POST = 'post';
    const MIGRATION_TYPE_HARD = 'hard';

    const MIGRATION_COMMAND_NEW_ALL = 'new all';

    /** @var \whotrades\RdsSystem\Model\Rabbit\MessagingRdsMs */
    private $model;

    /** @var DeployService */
    protected $deployService;

    /** @var PosixGroupManager */
    protected $posixGroupManager;

    public function __construct($id, $module, DeployService $deployService, PosixGroupManager $posixGroupManager, $config = [])
    {
        $this->deployService = $deployService;
        $this->posixGroupManager = $posixGroupManager;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $this->model  = $this->getMessagingModel();

        $this->attachEvents();

        $this->model->getBuildTask($workerName, false, function (Message\BuildTask $task) use ($workerName) {
            Yii::info("Build task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            try {
                $this->posixGroupManager->setCurrentPidAsGid();
                $this->createPidFiles($workerName, $task->id);
                $this->deployService->deployBuild($task);
            } catch (ScriptExecutorException $e) {
                $this->processCommandExecutorException($e, $task->version, 'failed');
            } catch (StopBuildTask $e) {
                $sigName = $this->mapSigNoToName($e->getSigno());
                Yii::error("Stop processing task with signal $sigName");
                $this->sendStatus('failed', $task->id, $task->version, "Processing of task was stopped with signal $sigName");
            } finally {
                $this->posixGroupManager->restoreGid();
            }

        });

        $this->model->getInstallTask($workerName, false, function (Message\InstallTask $task) use ($workerName) {
            Yii::info("Install task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            try {
                $this->posixGroupManager->setCurrentPidAsGid();
                $this->createPidFiles($workerName, $task->id);
                $this->deployService->deployInstall($task);
            } catch (ScriptExecutorException $e) {
                $this->processCommandExecutorException($e, $task->version, 'failed');
            } catch (StopBuildTask $e) {
                $sigName = $this->mapSigNoToName($e->getSigno());
                Yii::error("Stop processing task with signal $sigName");
                $this->sendStatus('failed', $task->id, $task->version, "Processing of task was stopped with signal $sigName");
            } finally {
                $this->posixGroupManager->restoreGid();
            }
        });

        try {
            $this->waitForMessages($this->model);
        } catch (StopBuildTask $e) {

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
     * @param ScriptExecutorException $e
     * @param string $version
     * @param string $sendStatus
     */
    private function processCommandExecutorException(ScriptExecutorException $e, $version, $sendStatus)
    {
        $previous = $e->getPrevious();
        if ($previous instanceof CommandExecutorException) {
            $text = $e->output;
            Yii::error("Last command: " . $previous->getCommand());
            $buildLog = "Failed to execute " . $e->getCommand() . "\n";
            $buildLog .= "Command output " . $text . "\n";
        } else {
            $buildLog = $e->getMessage();
        }

        $this->sendStatus($sendStatus, $version, $buildLog);
    }

    /**
     * Отправляет на сервер текущий статус сборки на конкретной машине сборщике
     *
     * @param $status
     * @param int $taskId
     * @param null $version
     * @param null $attach
     */
    private function sendStatus($status, int $taskId, $version = null, $attach = null)
    {
        Yii::info("Task status changed: status=$status, version=$version, attach_length=" . strlen($attach));
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
