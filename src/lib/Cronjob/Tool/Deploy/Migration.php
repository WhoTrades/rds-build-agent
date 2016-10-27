<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Migration -vv
 */
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

class Cronjob_Tool_Deploy_Migration extends \RdsSystem\Cron\RabbitDaemon
{
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
        $model  = $this->getMessagingModel($cronJob);
        $workerName = $cronJob->getOption('workerName');

        $model->getMigrationTask($workerName, false, function (\RdsSystem\Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            try {
                // an: Должно быть такое же, как в rebuild-package.sh
                $filename = "/home/release/buildroot/$task->project-$task->version/var/pkg/$task->project-$task->version/misc/tools/migration.php";

                // an: Это для препрода
                if (!file_exists($filename)) {
                    $filename = "/var/pkg/$task->project-$task->version/misc/tools/migration.php";
                }

                if (Config::getInstance()->debug) {
                    $filename = $task->project == 'comon' ? "/home/an/dev/comon/misc/tools/migration.php" : "/home/an/dev/services/$task->project/misc/tools/migration.php";
                }

                // an: Если миграции существуют, то есть есть в проекте
                if (file_exists($filename)) {
                    $command = "php $filename migration --type=$task->type --project=$task->project up --interactive=0 2>&1";
                    $commandExecutor->executeCommand($command);
                    $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'up'));
                } else {
                    // an: Если миграций нет - просто говорим что все ок
                    $this->debugLogger->message("Migration file $filename not found, so skip migrations");
                    $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'up'));
                }
            } catch (CommandExecutorException $e) {
                $this->debugLogger->error($e->getMessage());
                $this->debugLogger->info($e->output);
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->output));
            } catch (Exception $e) {
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->getMessage()));
            }

            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}
