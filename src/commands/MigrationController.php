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

class MigrationController extends RabbitListener
{
    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model  = $this->getMessagingModel();

        $model->getMigrationTask($workerName, false, function (\whotrades\RdsSystem\Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor();

            $projectDir = "/home/release/builds/$task->project-$task->version/";
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

                $model->sendMigrationStatus(new \whotrades\RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'up'));
            } catch (CommandExecutorException $e) {
                Yii::error($e->getMessage());
                Yii::info($e->output);
                $model->sendMigrationStatus(new \whotrades\RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->output));
            } catch (\Exception $e) {
                $model->sendMigrationStatus(new \whotrades\RdsSystem\Message\ReleaseRequestMigrationStatus($task->project, $task->version, $task->type, 'failed', $e->getMessage()));
            }

            unlink($migrationUpScriptFilename);

            $task->accepted();
        });

        $this->waitForMessages($model);
    }
}