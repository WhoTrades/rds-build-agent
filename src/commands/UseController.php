<?php
/**
 * @author Artem Naumenko
 * @example php yii.php use/index debian
 */

namespace app\commands;

use Raven_Client;
use RdsSystem\Cron\RabbitListener;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;
use Yii;
use RdsSystem\Message;

class UseController extends RabbitListener
{
    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model = $this->getMessagingModel();

        $model->getUseTask($workerName, false, function (\RdsSystem\Message\UseTask $task) use ($workerName, $model) {
            Yii::info("Task received: " . json_encode($task));
            $project = $task->project;
            $releaseRequestId = $task->releaseRequestId;
            $version = $task->version;
            $initiatorUserName = $task->initiatorUserName;

            $commandExecutor = new CommandExecutor();
            Yii::info("Using $project:$version, task_id=$releaseRequestId");

            try {
                $command = "bash bash/deploy.sh use $project $version 2>&1";
                if (Yii::$app->params['debug']) {
                    $command = "php bash/fakeUse.php $project $version $workerName";
                }
                $commandExecutor->executeCommand($command);

                Yii::info("Used version: $version");
                $model->sendUsedVersion(
                    new Message\ReleaseRequestUsedVersion($workerName, $project, $version, $initiatorUserName)
                );

                $task->accepted();

                Yii::info("Successful used $project-$version");
            } catch (CommandExecutorException $e) {
                $model->sendUseError(
                    new Message\ReleaseRequestUseError($task->releaseRequestId, $e->getMessage() . "\nOutput: " . $e->output)
                );
                Yii::error($e->getMessage());

                $task->accepted();
            }
        });

        $model->readProjectConfig($workerName, false, function (\RdsSystem\Message\ProjectConfig $task) use ($model) {
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
        });

        $this->waitForMessages($model);
    }
}
