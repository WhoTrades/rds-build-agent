<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Migration -vv
 */
class Cronjob_Tool_Deploy_Migration extends \RdsSystem\Cron\RabbitDaemon
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

        $model->getMigrationTask(false, function(\RdsSystem\Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            try {
                //an: Должно быть такое же, как в rebuild-package.sh
                $filename = "/home/release/buildroot/$task->project-$task->version/var/pkg/$task->project-$task->version/misc/tools/migration.php";

                if (Config::getInstance()->debug) {
                    $filename = "/home/dev/dev/comon/misc/tools/migration.php";
                }

                $command = "php $filename migration --type=$task->type --project=$task->project up --interactive=0";
                $commandExecutor->executeCommand($command);
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'up'));
            } catch (CommandExecutorException $e) {
                $this->debugLogger->error($e->getMessage());
                $this->debugLogger->info($e->output);
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed'));
            } catch (Exception $e) {
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed'));
            }

            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}
