<?php
/**
 * @author Artem Naumenko
 * @example php yii.php use/index debian
 */

namespace whotrades\RdsBuildAgent\commands;

use Raven_Client;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\CommandExecutor;
use whotrades\RdsSystem\lib\CommandExecutorException;
use Yii;
use whotrades\RdsSystem\Message;

class UseController extends RabbitListener
{
    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model = $this->getMessagingModel();

        $model->getUseTask($workerName, false, function (\whotrades\RdsSystem\Message\UseTask $task) use ($workerName, $model) {
            Yii::info("Task received: " . json_encode($task));
            $project = $task->project;
            $releaseRequestId = $task->releaseRequestId;
            $version = $task->version;
            $initiatorUserName = $task->initiatorUserName;

            $commandExecutor = new CommandExecutor();
            Yii::info("Using $project:$version, task_id=$releaseRequestId");

            try {
                if (empty($task->scriptUse)) {
                    $model->sendUseError(
                        new Message\ReleaseRequestUseError($task->releaseRequestId, $initiatorUserName, "Can't use project without use script")
                    );
                    Yii::error("Can't use project without use script");
                    $task->accepted();
                    return;
                }
                $env = [
                    'projectName' => $project,
                    'version' => $version,
                    'servers' => implode(" ", $task->projectServers),
                ];

                $useScriptFilename = "/tmp/deploy-use-" . uniqid() . ".sh";
                file_put_contents($useScriptFilename, str_replace("\r", "", $task->scriptUse));
                chmod($useScriptFilename, 0777);

                $command = "$useScriptFilename 2>&1";
                $text = $commandExecutor->executeCommand($command, $env);

                Yii::info("Use command output: $text");

                unlink($useScriptFilename);

                Yii::info("Used version: $version");
                $model->sendUsedVersion(
                    new Message\ReleaseRequestUsedVersion($workerName, $project, $version, $initiatorUserName, $text)
                );

                $task->accepted();

                Yii::info("Successful used $project-$version");
            } catch (CommandExecutorException $e) {
                $model->sendUseError(
                    new Message\ReleaseRequestUseError($task->releaseRequestId, $initiatorUserName, $e->getMessage() . "\nOutput: " . $e->output)
                );
                Yii::error($e->getMessage());

                $task->accepted();
            }
        });

        $model->readProjectConfig($workerName, false, function (\whotrades\RdsSystem\Message\ProjectConfig $task) use ($model) {
            Yii::info("Task received: " . json_encode($task));
            $project = $task->project;

            if (empty($task->scriptUploadConfigLocal)) {
                Yii::warning("Skip task, as scriptUploadConfigLocal is empty");
                $task->accepted();

                return;
            }

            $projectDir = "/tmp/config-local/$project-" . uniqid() . "/";
            if (!is_dir($projectDir)) {
                if (!mkdir($projectDir, 0777, true)) {
                    Yii::$app->sentry->captureMessage(
                        "cant_create_tmp_dir",
                        [
                            'project' => $project,
                            'projectDir' => $projectDir,
                        ],
                        Raven_Client::FATAL,
                        true
                    );

                    return;
                }
            }

            foreach ($task->configs as $filename => $content) {
                if (false === file_put_contents($projectDir . $filename, $content)) {
                    Yii::$app->sentry->captureMessage(
                        "cant_save_project_config",
                        [
                            'project' => $project,
                            'filename' => $projectDir . $filename,
                            'content' => $content,
                        ],
                        Raven_Client::FATAL,
                        true
                    );

                    return;
                }
            }

            $tmpScriptFilename = "/tmp/config-local-$project-" . uniqid() . ".sh";
            if (false === file_put_contents($tmpScriptFilename, str_replace("\r\n", "\n", $task->scriptUploadConfigLocal))) {
                Yii::$app->sentry->captureMessage(
                    "cant_save_tmp_shell_script",
                    [
                        'project' => $project,
                        'filename' => $tmpScriptFilename,
                        'content' => $task->scriptUploadConfigLocal,
                    ],
                    Raven_Client::FATAL,
                    true
                );

                return;
            }

            chmod($tmpScriptFilename, 0777);

            $env = [
                'projectName' => $project,
                'servers' => implode(" ", $task->getProjectServers()),
                'configDir' => $projectDir,
            ];

            $commandExecutor = new CommandExecutor();

            try {
                $output = $commandExecutor->executeCommand("$tmpScriptFilename 2>&1", $env);
                Yii::trace("Output: " . $output);

                foreach (glob("$projectDir/*") as $file) {
                    unlink($file);
                }
                rmdir($projectDir);
                unlink($tmpScriptFilename);

                Yii::info("Sync success");

                $task->accepted();
            } catch (CommandExecutorException $e) {
                $output = $e->getMessage() . "\nOutput: " . $e->output;

                Yii::$app->sentry->captureMessage(
                    "error_synchronization_config_local_skip_message",
                    [
                        'command' => $e->getCommand(),
                        'output' => $e->getOutput(),
                        'projectDir' => $projectDir,
                        'tmpScriptFilename' => $tmpScriptFilename,
                        'task' => [
                            'project' => $task->project,
                            'scriptUploadConfigLocal' => $task->scriptUploadConfigLocal,
                            'configs' => $task->configs,
                            'timeCreated' => $task->timeCreated,
                        ],
                    ],
                    Raven_Client::FATAL,
                    true
                );

                Yii::error("Skip message");

                $task->accepted();
            }

            $model->sendProjectConfigResult(
                new Message\ProjectConfigResult($task->projectConfigHistoryId, $output)
            );
        });

        $this->waitForMessages($model);
    }
}
