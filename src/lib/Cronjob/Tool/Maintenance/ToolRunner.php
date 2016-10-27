<?php
use RdsSystem\Message;

/**
 * Этот тул запускает обслуживающие команды из RDS и отправляет обратно в RDS прогресс выполнения команды и её stdout
 *
 * @example dev/services/deploy/misc/tools/runner.php --tool=Maintenance_ToolRunner -vv
 */
class Cronjob_Tool_Maintenance_ToolRunner extends RdsSystem\Cron\RabbitDaemon
{
    const LOG_LAG_TIME = 0.1;

    /** @var \RdsSystem\Model\Rabbit\MessagingRdsMs */
    private $model;

    /** @var  \RdsSystem\Message\MaintenanceTool\Start */
    private $currentTask;

    private $pid;

    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [
            'workerName' => [
                'desc' => 'Name of worker',
                'required' => true,
                'valueRequired' => true,
                'useForBaseName' => true,
            ],
        ] + parent::getCommandLineSpec();
    }

    /**
     * @param \Cronjob\ICronjob $cronJob
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $this->model = $this->getMessagingModel($cronJob);

        $this->gid = posix_getpgid(posix_getpid());
        $workerName = $cronJob->getOption('workerName');

        $this->model->readMaintenanceToolStart($workerName, false, function (\RdsSystem\Message\MaintenanceTool\Start $task) {
            $this->currentTask = $task;
            $task->accepted();
            $this->debugLogger->message("Task started");

            posix_setpgid(posix_getpid(), posix_getpid());

            $this->pid = posix_getpgid(posix_getpid());
            $this->debugLogger->message("Started command with PID=$this->pid, sending status to RDS");

            $this->model->sendMaintenanceToolChangeStatus(new \RdsSystem\Message\MaintenanceTool\ChangeStatus($task->id, 'in-progress', $this->pid));

            $output = "";
            $t = microtime(true);
            $chunk = "";
            ob_start(function ($string) use ($task, &$t, &$chunk, &$output) {
                $chunk .= $string;
                $output .= $string;
                fwrite(STDOUT, $string);

                if ($chunk && microtime(true) - $t > self::LOG_LAG_TIME) {
                    $t = microtime(true);
                    $this->model->sendMaintenanceToolLogChunk(new \RdsSystem\Message\MaintenanceTool\LogChunk($task->id, $chunk));

                    $this->debugLogger->message("Sending chunk `$chunk`");
                    $chunk = "";
                }
            }, 10);

            system($task->command . " 2>&1", $returnVar);

            $output = $chunk . ob_get_clean();

            if ($output) {
                $this->model->sendMaintenanceToolLogChunk(new \RdsSystem\Message\MaintenanceTool\LogChunk($task->id, $chunk));
            }

            if (!$returnVar) {
                $this->model->sendMaintenanceToolChangeStatus(new \RdsSystem\Message\MaintenanceTool\ChangeStatus($task->id, 'done', $this->pid));
                $this->debugLogger->message("Task successful finished");
            } else {
                $this->model->sendMaintenanceToolChangeStatus(new \RdsSystem\Message\MaintenanceTool\ChangeStatus($task->id, 'failed', $this->pid));
                $this->debugLogger->message("Failed to run command, sending to RDS");
            }

            $this->debugLogger->message("Restoring pgid");
            posix_setpgid(posix_getpid(), $this->gid);
        });

        $this->waitForMessages($this->model, $cronJob);
    }

    /**
     * @param int $signo
     */
    public function onTerm($signo)
    {
        $this->debugLogger->message("Caught signal $signo");
        if ($signo == SIGTERM || $signo == SIGINT) {
            $this->debugLogger->message("Cancelling...");
            $this->model->sendMaintenanceToolChangeStatus(new \RdsSystem\Message\MaintenanceTool\ChangeStatus($this->currentTask->id, 'failed', $this->pid));
            $this->debugLogger->message("Cancelled...");
        }

        CoreLight::getInstance()->getFatalWatcher()->stop();
        //an: выходим со статусом 0, что бы periodic не останавливался
        exit(0);
    }
}
