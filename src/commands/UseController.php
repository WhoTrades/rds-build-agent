<?php
/**
 * @author Artem Naumenko
 * @author Maksim Rodikov
 * @example php yii.php use/index debian
 */

namespace whotrades\RdsBuildAgent\commands;

use samdark\log\PsrMessage;
use whotrades\RdsBuildAgent\services\DeployService;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\Exception\EmptyAttributeException;
use whotrades\RdsSystem\lib\Exception\FilesystemException;
use whotrades\RdsSystem\lib\Exception\ScriptExecutorException;
use whotrades\RdsSystem\Message;
use whotrades\RdsSystem\Model\Rabbit\MessagingRdsMs;
use Yii;
use yii\base\Event;

class UseController extends RabbitListener
{
    /** @var DeployService */
    private $deployService;
    /** @var MessagingRdsMs */
    private $model;
    /** @var string */
    private $worker;

    public function __construct($id, $module, DeployService $deployService, $config = null)
    {
        $config = $config ?? [];
        $this->deployService = $deployService;
        $this->model = $this->getMessagingModel();
        $this->attachEvents();
        parent::__construct($id, $module, $config);
    }

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $this->worker = $workerName;
        $this->model->getUseTask($workerName, false, function (Message\UseTask $task) use ($workerName) {
            try {
                $this->deployService->useProjectVersion($task);
            } catch (EmptyAttributeException | FilesystemException | CommandExecutorException | ScriptExecutorException $e) {
                $previous = $e->getPrevious();
                if ($previous instanceof CommandExecutorException) {
                    $text = $previous->getOutput();
                    $buildLog = "Failed to execute " . $previous->getCommand() . "\n";
                    $buildLog .= "Command output " . $text . "\n";
                } else {
                    $buildLog = "";
                }
                Yii::error(new PsrMessage("error_use_message", [
                    'script' => $e->getScript(),
                    'output' => $buildLog,
                    'projectName' => $task->project,
                    'version' => $task->version,
                ]));

                $this->model->sendUseError(
                    new Message\ReleaseRequestUseError($task->releaseRequestId, $task->initiatorUserName, $e->getMessage())
                );
            }

        });

        $this->model->readProjectConfig($workerName, false, function (Message\ProjectConfig $task) {
            try {
                $output = $this->deployService->useProjectConfigLocal($task);
            } catch (EmptyAttributeException | FilesystemException | CommandExecutorException $e) {
                $output = $e->getMessage();
            }

            $this->model->sendProjectConfigResult(
                new Message\ProjectConfigResult($task->projectConfigHistoryId, $output)
            );
        });

        $this->waitForMessages($this->model);
    }

    private function attachEvents()
    {
        Event::on(DeployService::class, DeployService::EVENT_USE_FINISH, function (DeployService\Event\UseFinishEvent $event) {
            Yii::info(sprintf("Use command output: %s", $event->getPayload()));
            Yii::info(sprintf("Used version: %s", $event->getVersion()));
            $this->model->sendUsedVersion(
                new Message\ReleaseRequestUsedVersion($this->worker, $event->getProject(), $event->getVersion(), $event->getInitiatorUserName(), $event->getPayload())
            );
        });

        Event::on(DeployService::class, DeployService::EVENT_POST_USE_FINISH, function (DeployService\Event\PostUseFinishEvent $event) {
            Yii::info(sprintf("Successful used %s-%s", $event->getProject(), $event->getVersion()));
        });
    }
}
