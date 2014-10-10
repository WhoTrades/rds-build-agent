<?php
use RdsSystem\Message;

/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_HardMigration -vv
 */
class Cronjob_Tool_Deploy_HardMigration extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $rdsSystem = new RdsSystem\Factory($this->debugLogger);
        $model  = $rdsSystem->getMessagingRdsMsModel();
        $workerName = \Config::getInstance()->workerName;

        $model->getHardMigrationTask(false, function(\RdsSystem\Message\HardMigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            try {
                //an: Должно быть такое же, как в rebuild-package.sh
                $filename = "/home/release/buildroot/$task->project-$task->version/var/pkg/$task->project-$task->version/misc/tools/migration.php";

                if (Config::getInstance()->debug) {
                    $filename = "/home/an/dev/services/rds/misc/tools/migration.php";
                }

                $model->sendHardMigrationStatus(new \RdsSystem\Message\HardMigrationStatus($task->migration, 'process'));

                $host = Cronjob_Tool_Deploy_HardMigrationProxy::LISTEN_HOST;
                $port = Cronjob_Tool_Deploy_HardMigrationProxy::LISTEN_PORT;
                $command = "php $filename migration --type=hard --project=$task->project --progressHost=$host --progressPort=$port upOne ".str_replace("/", "\\\\", $task->migration)." -vv 2>&1";

                $text = $commandExecutor->executeCommand($command);
                $model->sendHardMigrationStatus(new \RdsSystem\Message\HardMigrationStatus($task->migration, 'done', $text));
            } catch (CommandExecutorException $e) {
                //an: 66 - это остановка миграции из RDS
                if ($e->getCode() == 66) {
                    $this->debugLogger->message("Stopped migration via RDS signal");
                    $model->sendHardMigrationStatus(new \RdsSystem\Message\HardMigrationStatus($task->migration, 'stopped', $e->output));
                } else {
                    $this->debugLogger->error($e->getMessage());
                    $this->debugLogger->info($e->output);
                    $model->sendHardMigrationStatus(new \RdsSystem\Message\HardMigrationStatus($task->migration, 'failed', $e->output));
                }
            } catch (Exception $e) {
                $model->sendHardMigrationStatus(new \RdsSystem\Message\HardMigrationStatus($task->migration, 'failed', $e->getMessage()));
            }

            $task->accepted();
        });

        $this->debugLogger->message("Start listening");

        $this->waitForMessages($model, $cronJob);
    }
}
