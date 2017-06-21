<?php
/**
 * Скрипт, который выполняет быстрые операции USE и выкладку конфигов
 * @author Artem Naumenko
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Use -vv
 */

use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

class Cronjob_Tool_Deploy_Use extends \RdsSystem\Cron\RabbitDaemon
{
    /**
     * Use this function to get command line spec for cronjob
     *
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
        $model = $this->getMessagingModel($cronJob);

        $workerName = $cronJob->getOption('worker-name');
        $model->getUseTask($workerName, false, function (\RdsSystem\Message\UseTask $task) use ($workerName, $model) {
            $this->debugLogger->message("Task received: " . json_encode($task));
            $project = $task->project;
            $releaseRequestId = $task->releaseRequestId;
            $version = $task->version;
            $initiatorUserName = $task->initiatorUserName;

            $commandExecutor = new CommandExecutor($this->debugLogger);
            $this->debugLogger->message("Using $project:$version, task_id=$releaseRequestId");

            try {
                $command = "bash bash/deploy.sh status $project 2>&1";

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeStatus_$project.php";
                }
                $text = $commandExecutor->executeCommand($command);
                $this->debugLogger->message($text);

                $oldVersion = null;
                foreach (array_filter(explode("\n", str_replace("\r", "", $text))) as $line) {
                    if (false === strpos($line, ' ')) {
                        $model->sendUseError(new Message\ReleaseRequestUseError($task->releaseRequestId, "Invalid output of status script:\n" . $text));
                        $task->accepted();

                        return;
                    }
                    list($server, $sv) = explode(" ", $line);

                    $this->debugLogger->message("ServerRegex: " . \Config::getInstance()->serverRegex);
                    if (!preg_match(\Config::getInstance()->serverRegex, $server)) {
                        continue;
                    }

                    if ($oldVersion === null) {
                        $oldVersion = $sv;
                    } elseif ($oldVersion != $sv) {
                        $model->sendUseError(new Message\ReleaseRequestUseError($task->releaseRequestId, "Versions of project different on servers:\n" . $text));
                        $task->accepted();

                        return;
                    }
                }

                if ($oldVersion === null) {
                    $this->debugLogger->error("Use error as empty oldVersion");
                    $model->sendUseError(
                        new Message\ReleaseRequestUseError($task->releaseRequestId, "Empty oldVersion")
                    );
                    $task->accepted();

                    return;
                }

                $oldVersion = str_replace("$project-", "", $oldVersion);
                $oldVersion = preg_replace("~\-1$~", "", $oldVersion);

                $model->sendOldVersion(
                    new Message\ReleaseRequestOldVersion($task->releaseRequestId, $oldVersion)
                );

                $command = "bash bash/deploy.sh use $project $version 2>&1";
                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeUse.php $project $version $workerName";
                }
                $commandExecutor->executeCommand($command);

                try {
                    $this->debugLogger->message("Used version: $version");
                    $model->sendUsedVersion(
                        new Message\ReleaseRequestUsedVersion($workerName, $project, $version, $initiatorUserName)
                    );
                } catch (\Exception $e) {
                    $this->debugLogger->message("Can't send to server real used version, reverting\n");
                    $command = "bash bash/deploy.sh use $project $oldVersion 2>&1";
                    if (Config::getInstance()->debug) {
                        $command = "php bash/fakeUse.php $project $version $workerName";
                    }
                    $commandExecutor->executeCommand($command);
                    $model->sendUsedVersion(
                        new Message\ReleaseRequestUsedVersion($workerName, $project, $version, $initiatorUserName)
                    );
                }

                $task->accepted();

                $this->debugLogger->message("Successful used $project-$version");
            } catch (CommandExecutorException $e) {
                $model->sendUseError(
                    new Message\ReleaseRequestUseError($task->releaseRequestId, $e->getMessage() . "\nOutput: " . $e->output)
                );
                $this->debugLogger->error($e->getMessage());

                $task->accepted();
            }
        });

        $model->readProjectConfig($workerName, false, function (\RdsSystem\Message\ProjectConfig $task) use ($model) {
            $this->debugLogger->message("Task received: " . json_encode($task));
            $project = $task->project;

            if (empty($task->scriptUploadConfigLocal)) {
                $this->debugLogger->warning("Skip task, as scriptUploadConfigLocal is empty");
                $task->accepted();

                return;
            }

            $projectDir = "/tmp/config-local/$project-" . uniqid() . "/";
            if (!is_dir($projectDir)) {
                if (!mkdir($projectDir, 0777, true)) {
                    $this->debugLogger->dump()->message("an", "cant_create_tmp_dir", false, [
                        'project' => $project,
                        'projectDir' => $projectDir,
                    ])->critical()->save();

                    return;
                }
            }

            foreach ($task->configs as $filename => $content) {
                if (false === file_put_contents($projectDir . $filename, $content)) {
                    $this->debugLogger->dump()->message("an", "cant_save_project_config", false, [
                        'project' => $project,
                        'filename' => $projectDir . $filename,
                        'content' => $content,
                    ])->critical()->save();

                    return;
                }
            }

            $tmpScriptFilename = "/tmp/config-local-$project-" . uniqid() . ".sh";
            if (false === file_put_contents($tmpScriptFilename, str_replace("\r\n", "\n", $task->scriptUploadConfigLocal))) {
                $this->debugLogger->dump()->message("an", "cant_save_tmp_shell_script", false, [
                    'project' => $project,
                    'filename' => $tmpScriptFilename,
                    'content' => $task->scriptUploadConfigLocal,
                ])->critical()->save();

                return;
            }

            chmod($tmpScriptFilename, 0777);

            $env = [
                'projectName' => $project,
                'servers' => 'debug test-server-a test-server-b',
                'configDir' => $projectDir,
            ];

            $commandExecutor = new CommandExecutor($this->debugLogger);

            try {
                $output = $commandExecutor->executeCommand("$tmpScriptFilename 2>&1", $env);
                $this->debugLogger->debug("Output: " . $output);

                foreach (glob("$projectDir/*") as $file) {
                    unlink($file);
                }
                rmdir($projectDir);
                unlink($tmpScriptFilename);

                $this->debugLogger->message("Sync success");

                $task->accepted();
            } catch (CommandExecutorException $e) {
                $this->debugLogger->dump()->message('an', 'error_synchronization_config_local_skip_message', false, [
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
                ]);

                $this->debugLogger->error("Skip message");

                $task->accepted();
            }
        });

        $this->waitForMessages($model, $cronJob);
    }
}
