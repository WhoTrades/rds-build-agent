<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Killer -vv
 */
class Cronjob_Tool_Deploy_Killer extends \RdsSystem\Cron\RabbitDaemon
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }


    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model  = $this->getMessagingModel($cronJob);
        $workerName = \Config::getInstance()->workerName;

        $model->getKillTask($workerName, false, function(\RdsSystem\Message\KillTask $task) use ($model, $workerName) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            $this->debugLogger->message("Killing $task->project, task_id=$task->taskId");

            $filename = \Config::getInstance()->pid_dir."/{$workerName}_deploy_$task->taskId.php.pid";
            if (!file_exists($filename)) {
                $this->debugLogger->message("No pid file $filename, may be process already finished");
                $task->accepted();
                return;
            }
            $pid = file_get_contents($filename);
            $this->debugLogger->message("Pid: $pid at filename $filename");

            try {
                $commandExecutor->executeCommand("kill -- -$pid");
            } catch (CommandExecutorException $e) {
                $this->debugLogger->error($e->getMessage());
            }

            $task->accepted();
        });

        $model->readUnixSignals(false, function(\RdsSystem\Message\UnixSignal $message) use ($model, $workerName) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            $this->debugLogger->message("Sending signal $message->signal to PID=$message->pid");

            try {
                $commandExecutor->executeCommand("kill -$message->signal $message->pid");
            } catch (CommandExecutorException $e) {
                $this->debugLogger->error($e->getMessage());
            }

            $message->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}
