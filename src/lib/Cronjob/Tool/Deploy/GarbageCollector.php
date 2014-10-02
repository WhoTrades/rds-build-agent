<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_GarbageCollector -vv
 */

use \RdsSystem\Message;

class Cronjob_Tool_Deploy_GarbageCollector extends \RdsSystem\Cron\RabbitDaemon
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return array(
            'dry-run' => array(
                'desc' => 'do not remove any packages, only output information about them',
                'default' => false,
            ),
        ) + parent::getCommandLineSpec();
    }


    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $rdsSystem = new RdsSystem\Factory($this->debugLogger);
        $model  = $rdsSystem->getMessagingRdsMsModel();
        $model->sendGetProjectsRequest(new Message\ProjectsRequest());
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $model->readGetProjectsReply(false, function(Message\ProjectsReply $message) use ($model, $cronJob, $commandExecutor) {
            $toTest = array();
            foreach ($message->projects as $project) {
                $command = Config::getInstance()->debug ? "cat bash/whotrades_repo.txt" : "reprepro -b /var/www/whotrades_repo/ listmatched wheezy '{$project['name']}-*'";
                $text = $commandExecutor->executeCommand($command);
                if (preg_match_all('~'.$project['name'].'-([\d.]+)~', $text, $ans)) {
                    $versions = $ans[1];
                    foreach ($versions as $version) {
                        $toTest[$project['name']."-".$version] = array(
                            'project' => $project['name'],
                            'version' => $version,
                        );
                    }
                } else {
                    $this->debugLogger->message("No builds of {$project['name']} found");
                }
            }

            $command = Config::getInstance()->debug ? "cat bash/whotrades_builds.txt" : "find /home/release/buildroot/ -maxdepth 1 -type d";
            $text = $commandExecutor->executeCommand($command);
            if (preg_match_all('~([\w-]{5,})-([\d.]{5,})~', $text, $ans)) {
                $versions = $ans[2];
                foreach ($versions as $key => $version) {
                    $project = $ans[1][$key];
                    $toTest["$project-$version"] = array(
                        'project' => $project,
                        'version' => $version,
                    );
                }
            } else {
                $this->debugLogger->message("No builds at /home/release/buildroot/ found");
            }

            $model->sendGetProjectBuildsToDeleteRequest(new Message\ProjectBuildsToDeleteRequest($toTest));

            $message->accepted();
        });

        $model->readGetProjectBuildsToDeleteReply(false, function(Message\ProjectBuildsToDeleteReply $buildsReply) use ($model, $cronJob, $commandExecutor) {
            foreach ($buildsReply->buildToDelete as $val) {
                $project = $val['project'];
                $version = $val['version'];
                if (strlen($project) < 3) continue;
                if (strlen($version) < 3) continue;
                if ($cronJob->getOption('dry-run')) {
                    $this->debugLogger->message("Fake removing $project-$version");
                } else {
                    $this->debugLogger->message("Removing $project-$version");
                    if (is_dir("/home/release/buildroot/$project-$version")) {
                        $commandExecutor->executeCommand("rm -rf /home/release/buildroot/$project-$version");
                    }
                    try {
                        $commandExecutor->executeCommand("bash bash/deploy.sh remove $project $version");
                    } catch (CommandExecutorException $e) {
                        if ($e->getCode() != 1) {
                            //an: Код 1 - допустим, его игнорируем, значит просто не на всех серверах была установлена эта сборка
                            throw new CommandExecutorException($e->getMessage(), $e->getCode(), $e->output, $e);
                        }
                    }
                    $commandExecutor->executeCommand("reprepro -b /var/www/whotrades_repo/ remove wheezy $project-$version");
                    $model->removeReleaseRequest(new Message\RemoveReleaseRequest($project, $version));
                }
            }

            $buildsReply->accepted();
        });

        try {
            $model->waitForMessages(null, null, 30);
        } catch (PhpAmqpLib\Exception\AMQPTimeoutException $e) {

        }
    }
}
