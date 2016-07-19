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
        return [] + parent::getCommandLineSpec();
    }

    /**
     * @param \Cronjob\ICronjob $cronJob
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model = $this->getMessagingModel($cronJob);

        $workerName = \Config::getInstance()->workerName;
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
                $text = $commandExecutor->executeCommand($command);

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeStatus_$project.php";
                }

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

        $model->readProjectConfig(false, function (\RdsSystem\Message\ProjectConfig $task) use ($model) {
            $this->debugLogger->message("Task received: " . json_encode($task));
            $project = $task->project;

            $files = glob("/etc/$project/*");
            foreach ($files as $file) {
                if (!unlink($file)) {
                    $this->debugLogger->dump()->message("an", "cant_remove_old_project_config", false, [
                        'project' => $project,
                        'filename' => $file,
                    ])->critical()->save();

                    return;
                }
            }

            foreach ($task->configs as $filename => $content) {
                if (false === file_put_contents("/etc/$project/" . $filename, $content)) {
                    $this->debugLogger->dump()->message("an", "cant_save_project_config", false, [
                        'project' => $project,
                        'filename' => "/etc/$project/" . $filename,
                        'content' => $content,
                    ])->critical()->save();

                    return;
                }
            }

            $commandExecutor = new CommandExecutor($this->debugLogger);

            if (Config::getInstance()->debug) {
                $command = "sleep 1 #$project";
            } else {
                $command = "bash bash/cmd.sh sync-conf $project 2>&1";
            }
            $commandExecutor->executeCommand($command);

            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}
