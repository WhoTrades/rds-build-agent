<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Migration_JiraTickets -vv
 */

use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

class Cronjob_Tool_Migration_JiraTickets extends Cronjob\Tool\ToolBase
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
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $projects = RemoteModel::getInstance()->getProjects();

        $this->debugLogger->info("started");

        foreach ($projects as $projectItem) {
            $project = $projectItem['name'];
            if ($project == 'dictionary') {
                continue;
            }

            $this->debugLogger->info("Processing project $project");

            $releaseRequests = RemoteModel::getInstance()->getReleaseRequests($project);

            foreach ($releaseRequests as $releaseRequest) {
                //an: Отправляем на сервер какие тикеты были в этом билде
                $srcDir="/home/release/build/$project";

                $version = $releaseRequest['version'];
                $oldVersion = $releaseRequest['old_version'];

                if (!$oldVersion) {
                    continue;
                }

                $this->debugLogger->info("Processing release request $project-$version");

                $command = "(cd $srcDir/lib; node /home/release/git-tools/alias/git-all.js \"git log $project-$oldVersion..$project-$version --pretty='%H|%s|/%an/'\")";

                if (Config::getInstance()->debug) {
                    $command = "cat /home/an/log.txt";
                }

                try {
                    $output = $commandExecutor->executeCommand($command);
                } catch (CommandExecutorException $e) {
                    //an: Означает что в каком-то репоитории нет метки
                    if ($e->getCode() == 127) {
                        $output = $e->output;
                    } else {
                        throw $e;
                    }
                }

                RemoteModel::getInstance()->sendBuildPatch($project, $version, $output);
            }
        }

        $this->debugLogger->info("finished");
    }
}
