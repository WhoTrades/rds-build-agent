<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\CommandExecutor;
use whotrades\RdsSystem\lib\CommandExecutorException;
use Yii;
use whotrades\RdsSystem\Message;

class KillerController extends RabbitListener
{
    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model  = $this->getMessagingModel();

        $model->getKillTask($workerName, false, function (\whotrades\RdsSystem\Message\KillTask $task) use ($model, $workerName) {
            $commandExecutor = new CommandExecutor();

            Yii::info("Killing $task->project, task_id=$task->taskId");

            $filename = Yii::$app->params['pidDir'] . "/{$workerName}_deploy_$task->taskId.php.pid";
            if (!file_exists($filename)) {
                Yii::info("No pid file $filename, may be process already finished");
                $model->sendTaskStatusChanged(
                    new Message\TaskStatusChanged($task->taskId, 'cancelled')
                );
                $task->accepted();

                return;
            }
            $pid = file_get_contents($filename);
            Yii::info("Pid: $pid at filename $filename");

            try {
                $commandExecutor->executeCommand("kill -- -$pid");
            } catch (CommandExecutorException $e) {
                Yii::error($e->getMessage());
            }

            $task->accepted();
        });

        $model->readUnixSignals($workerName, false, function (\whotrades\RdsSystem\Message\UnixSignal $message) use ($model, $workerName) {
            $commandExecutor = new CommandExecutor();

            Yii::info("Sending signal $message->signal to PID=$message->pid");

            try {
                $commandExecutor->executeCommand("kill -$message->signal $message->pid");
            } catch (CommandExecutorException $e) {
                Yii::error($e->getMessage());
            }

            $message->accepted();
        });

        $model->readUnixSignalsToGroup($workerName, false, function (\whotrades\RdsSystem\Message\UnixSignalToGroup $message) use ($model, $workerName) {
            $commandExecutor = new CommandExecutor();

            Yii::info("Sending signal to PGID=$message->pgid");

            try {
                $commandExecutor->executeCommand("kill -- -$message->pgid");
            } catch (CommandExecutorException $e) {
                Yii::error($e->getMessage());
            }

            $message->accepted();
        });

        $this->waitForMessages($model);
    }
}
