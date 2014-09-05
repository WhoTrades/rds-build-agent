<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Use -vv
 */
class Cronjob_Tool_Deploy_Use extends Cronjob\Tool\ToolBase
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return array();
    }


    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $workerName = \Config::getInstance()->workerName;
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $data = RemoteModel::getInstance()->getUseTask($workerName);
        if (!$data) {
            return;
        }

        $project = $data['project'];
        $taskId = $data['id'];
        $version = $data['version'];
        $useStatus = $data['use_status'];

        $this->debugLogger->message("Using $project:$version, task_id=$taskId");

        try {
            $command = "bash bash/deploy.sh status $project 2>&1";

            if (Config::getInstance()->debug) {
                $command = "php bash/fakeStatus_".Config::getInstance()->workerName.".php";
            }
            $text = $commandExecutor->executeCommand($command);
            $this->debugLogger->message($text);

            $oldVersion = null;
            foreach (array_filter(explode("\n", str_replace("\r", "", $text))) as $line) {
                if (false === strpos($line, ' ')) {
                    RemoteModel::getInstance()->setUseError($taskId, "Invalid output of status script:\n" . $text);
                    return;
                }
                list($server, $sv) = explode(" ", $line);
                if ($oldVersion === null) {
                    $oldVersion = $sv;
                } elseif ($oldVersion != $sv) {
                    RemoteModel::getInstance()->setUseError($taskId, "Versions of project different on servers:\n".$text);
                    return;
                }
            }

            $oldVersion = str_replace("$project-", "", $oldVersion);
            $oldVersion = preg_replace("~\-1$~", "", $oldVersion);

            $reply = RemoteModel::getInstance()->setOldVersion($taskId, $oldVersion);
            if (!$reply['ok']) {
                $this->debugLogger->message("Can't send old version of $project to server");
                return;
            }

            $command = "bash bash/deploy.sh use $project $version 2>&1";
            if (Config::getInstance()->debug) {
                $command = "php bash/fakeUse.php $project $version ".Config::getInstance()->workerName;
            }
            $text = $commandExecutor->executeCommand($command);

            if (Config::getInstance()->debug) {
                $command = "php bash/fakeStatus_".Config::getInstance()->workerName.".php";
            }

            try {
                RemoteModel::getInstance()->setUsedVersion(\Config::getInstance()->workerName, $project, $version, $useStatus);
            } catch (\Exception $e) {
                $this->debugLogger->message("Can't send to server real used version, reverting\n");
                $command = "bash bash/deploy.sh use $project $oldVersion 2>&1";
                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeUse.php $project $version ".Config::getInstance()->workerName;
                }
                $text = $commandExecutor->executeCommand($command);
                RemoteModel::getInstance()->setUsedVersion(\Config::getInstance()->workerName, $project, $oldVersion, 'used');
            }

            if ($useStatus == 'used_attempt') {
                sleep(15);

                $reply = RemoteModel::getInstance()->getCurrentStatus($taskId);
                if ($reply['status'] != 'used') {
                    $this->debugLogger->message("Reverting $project back to v.$oldVersion, task_id=$taskId");
                    $command = "bash bash/deploy.sh use $project $oldVersion 2>&1";
                    if (Config::getInstance()->debug) {
                        $command = "php bash/fakeUse.php $project $oldVersion ".Config::getInstance()->workerName;
                    }
                    $text = $commandExecutor->executeCommand($command);
                    RemoteModel::getInstance()->setUsedVersion(\Config::getInstance()->workerName, $project, $oldVersion, 'used');
                } else {
                    $this->debugLogger->message("Project $project v.$version marked as stable, skip reverting, task_id=$taskId");
                }
            }

        } catch (CommandExecutorException $e) {
            RemoteModel::getInstance()->setUseError($taskId, $e->getMessage()."\nOutput: ".$e->output);
            $this->debugLogger->message($e->getMessage()."\n");
        }
    }
}
