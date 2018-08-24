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
    const MIGRATION_COMMAND_UP = 'up';
    const MIGRATION_COMMAND_UP_ONE = 'up-one';

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model  = $this->getMessagingModel();

        $model->getMigrationTask($workerName, false, function (Message\MigrationTask $task) use ($workerName, $model) {
            $commandExecutor = new CommandExecutor();

            $projectDir = "/home/release/builds/$task->project-$task->version/";
            $migrationUpScriptFilename = "/tmp/migration-up-script-" . uniqid() . ".sh";

            try {
                file_put_contents($migrationUpScriptFilename, str_replace("\r", "", $task->scriptMigrationUp));
                chmod($migrationUpScriptFilename, 0777);

                $migrationCommand = $task->migrationName ? self::MIGRATION_COMMAND_UP_ONE : self::MIGRATION_COMMAND_UP;

                $env = [
                    'projectName' => $task->project,
                    'type' => $task->type,
                    'projectDir' => $projectDir,
                    'migrationCommand' => $migrationCommand,
                    'migrationName' => $task->migrationName,
                ];
                $result = $commandExecutor->executeCommand("$migrationUpScriptFilename 2>&1", $env);

                $model->sendMigrationStatus(
                    new Message\MigrationStatus(
                        $task->project,
                        $task->version,
                        $task->type,
                        $task->migrationName,
                        Message\MigrationStatus::STATUS_UP,
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