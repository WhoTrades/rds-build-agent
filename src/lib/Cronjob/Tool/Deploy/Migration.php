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
            'worker-name' => [
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
        $workerName = $cronJob->getOption('worker-name');

        $model->getMigrationTask($workerName, false, function (\RdsSystem\Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor($this->debugLogger);

            $projectDir = "/home/release/buildroot/$task->project-$task->version/var/pkg/$task->project-$task->version/";
            $migrationUpScriptFilename = "/tmp/migration-up-script-" . uniqid() . ".sh";

            try {
                file_put_contents($migrationUpScriptFilename, str_replace("\r", "", $task->scriptMigrationUp));
                chmod($migrationUpScriptFilename, 0777);

                $env = [
                    'projectName' => $task->project,
                    'type' => $task->type,
                    'projectDir' => $projectDir,
                ];
                $commandExecutor->executeCommand("$migrationUpScriptFilename 2>&1", $env);

                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'up'));
            } catch (CommandExecutorException $e) {
                $this->debugLogger->error($e->getMessage());
                $this->debugLogger->info($e->output);
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->output));
            } catch (Exception $e) {
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->getMessage()));
            }

            unlink($migrationUpScriptFilename);

            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}
