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

        $model->getMigrationTask($workerName, false, function (Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor();

            $migrationUpScriptFilename = "/tmp/migration-{$task->type}-script-" . uniqid() . ".sh";

            try {
                file_put_contents($migrationUpScriptFilename, str_replace("\r", "", $task->scriptMigrationUp));
                chmod($migrationUpScriptFilename, 0777);

                $env = [
                    'project' => $task->project,
                    'version' => $task->version,
                    'type' => $task->type,
                    'command' => $task->migrationCommand,
                    'migrationName' => $task->migrationName,
                ];
                $result = $commandExecutor->executeCommand("$migrationUpScriptFilename 2>&1", $env);

                $model->sendMigrationStatus(
                    new Message\MigrationStatus(
                        $task->project,
                        $task->version,
                        $task->type,
                        $task->migrationName,
                        Message\MigrationStatus::STATUS_SUCCESS,
                        $result
                    )
                );
            } catch (CommandExecutorException $e) {
                Yii::error($e->getMessage());
                Yii::info($e->output);
                $model->sendMigrationStatus(
                    new Message\MigrationStatus(
                        $task->project,
                        $task->version,
                        $task->type,
                        $task->migrationName,
                        Message\MigrationStatus::STATUS_FAILED,
                        $e->output
                    )
                );
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                $model->sendMigrationStatus(
                    new Message\MigrationStatus(
                        $task->project,
                        $task->version,
                        $task->type,
                        $task->migrationName,
                        Message\MigrationStatus::STATUS_FAILED,
                        $e->getMessage()
                    )
                );
            }

            unlink($migrationUpScriptFilename);

            $task->accepted();
        });

        $this->waitForMessages($model);
    }
}