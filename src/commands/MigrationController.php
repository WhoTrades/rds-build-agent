<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

use RdsSystem\Cron\RabbitListener;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;
use Yii;
use RdsSystem\Message;

class MigrationController extends RabbitListener
{
    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model  = $this->getMessagingModel();

        $model->getMigrationTask($workerName, false, function (\RdsSystem\Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor();

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
                Yii::error($e->getMessage());
                Yii::info($e->output);
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->output));
            } catch (\Exception $e) {
                $model->sendMigrationStatus(new \RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->getMessage()));
            }

            unlink($migrationUpScriptFilename);

            $task->accepted();
        });

        $this->waitForMessages($model);
    }
}