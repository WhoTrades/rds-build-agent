<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Use -vv
 */

use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

class Cronjob_Tool_Deploy_Use extends \RdsSystem\Cron\RabbitDaemon
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }


    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model  = $this->getMessagingModel($cronJob);

        $workerName = \Config::getInstance()->workerName;
        $model->getUseTask($workerName, false, function(\RdsSystem\Message\UseTask $task) use ($workerName, $model) {
            $this->debugLogger->message("Task received: ".json_encode($task));
            $project = $task->project;
            $releaseRequestId = $task->releaseRequestId;
            $version = $task->version;
            $useStatus = $task->useStatus;

            $commandExecutor = new CommandExecutor($this->debugLogger);
            $this->debugLogger->message("Using $project:$version, task_id=$releaseRequestId");

            try {
                $command = "bash bash/deploy.sh status $project 2>&1";

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeStatus_$workerName.php";
                }
                $text = $commandExecutor->executeCommand($command);
                $this->debugLogger->message($text);

                $oldVersion = null;
                foreach (array_filter(explode("\n", str_replace("\r", "", $text))) as $line) {
                    if (false === strpos($line, ' ')) {
                        $model->sendUseError(
                            new Message\ReleaseRequestUseError($task->releaseRequestId, "Invalid output of status script:\n" . $text)
                        );
                        $task->accepted();
                        return;
                    }
                    list($server, $sv) = explode(" ", $line);

                    $this->debugLogger->message("ServerRegex: ".\Config::getInstance()->serverRegex);
                    if (!preg_match(\Config::getInstance()->serverRegex, $server)) {
                        continue;
                    }

                    if ($oldVersion === null) {
                        $oldVersion = $sv;
                    } elseif ($oldVersion != $sv) {
                        $model->sendUseError(
                            new Message\ReleaseRequestUseError($task->releaseRequestId, "Versions of project different on servers:\n".$text)
                        );
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
                    $command = "php bash/fakeStatus_$workerName.php";
                }

                try {
                    $this->debugLogger->message("Used version: $version");
                    $model->sendUsedVersion(
                        new Message\ReleaseRequestUsedVersion($workerName, $project, $version, $useStatus)
                    );
                } catch (\Exception $e) {
                    $this->debugLogger->message("Can't send to server real used version, reverting\n");
                    $command = "bash bash/deploy.sh use $project $oldVersion 2>&1";
                    if (Config::getInstance()->debug) {
                        $command = "php bash/fakeUse.php $project $version $workerName";
                    }
                    $commandExecutor->executeCommand($command);
                    $model->sendUsedVersion(
                        new Message\ReleaseRequestUsedVersion($workerName, $project, $version, 'used')
                    );
                }

                if ($useStatus == 'used_attempt') {
                    $this->debugLogger->message("Sleeping 15 seconds");
                    sleep(15);

                    $this->debugLogger->message("Sended release request status request");

                    $model->sendCurrentStatusRequest(new Message\ReleaseRequestCurrentStatusRequest($task->releaseRequestId, $id = uniqid()));

                    $statusMessage = $model->getReleaseRequestStatus($task->releaseRequestId);
                    $this->debugLogger->message("Status of release request: '".$statusMessage->status."'");
                    if ($statusMessage->status != 'used') {
                        $this->debugLogger->message("Reverting $project back to v.$oldVersion, task_id=$task->releaseRequestId");
                        $command = "bash bash/deploy.sh use $project $oldVersion 2>&1";
                        if (Config::getInstance()->debug) {
                            $command = "php bash/fakeUse.php $project $oldVersion $workerName";
                        }
                        $commandExecutor->executeCommand($command);
                        $model->sendUsedVersion(
                            new Message\ReleaseRequestUsedVersion($workerName, $project, $oldVersion, 'used')
                        );
                    } else {
                        $this->debugLogger->message("Project $project v.$task->version marked as stable, skip reverting, task_id=$task->releaseRequestId");
                    }

                    $this->debugLogger->message("Processed revert logic");
                }

                $task->accepted();
                $this->debugLogger->message("Successful used $project-$version");

            } catch (CommandExecutorException $e) {
                $model->sendUseError(
                    new Message\ReleaseRequestUseError($task->releaseRequestId, $e->getMessage()."\nOutput: ".$e->output)
                );
                $this->debugLogger->error($e->getMessage());
            }
        });

        $this->waitForMessages($model, $cronJob);
    }
}
