<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

use RdsSystem\Cron\RabbitListener;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;
use Yii;
use PhpAmqpLib;
use RdsSystem\Message;

class GarbageCollectorController extends RabbitListener
{
    /**
     * @param bool $dryRun - remove packages or just print packages to remove
     */
    public function actionIndex($dryRun = null)
    {
        $dryRun = $dryRun ?? false;
        $model  = $this->getMessagingModel();
        $model->sendGetProjectsRequest(new Message\ProjectsRequest());
        $commandExecutor = new CommandExecutor();

        $model->readGetProjectsReply(false, function (Message\ProjectsReply $message) use ($model, $commandExecutor) {
            $toTest = array();
            foreach ($message->projects as $project) {
                $command = Yii::$app->params['debug'] ? "cat bash/whotrades_repo.txt" : "reprepro -b /var/www/whotrades_repo/ listmatched wheezy '{$project['name']}-*'";
                $text = $commandExecutor->executeCommand($command);
                if (preg_match_all('~' . $project['name'] . '-([\d.]+)~', $text, $ans)) {
                    $versions = $ans[1];
                    foreach ($versions as $version) {
                        $toTest[$project['name'] . "-" . $version] = array(
                            'project' => $project['name'],
                            'version' => $version,
                        );
                    }
                } else {
                    Yii::info("No builds of {$project['name']} found");
                }
            }

            $command = Yii::$app->params['debug'] ? "cat bash/whotrades_builds.txt" : "find /home/release/buildroot/ -maxdepth 1 -type d";
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
                Yii::info("No builds at /home/release/buildroot/ found");
            }

            $model->sendGetProjectBuildsToDeleteRequest(new Message\ProjectBuildsToDeleteRequest($toTest));

            $message->accepted();
        });

        $model->readGetProjectBuildsToDeleteReply(false, function (Message\ProjectBuildsToDeleteReply $task) use ($model, $dryRun, $commandExecutor) {
            Yii::info("Task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $project = $task->project;
            $version = $task->version;

            if (strlen($project) < 3) {
                $task->accepted();

                return;
            }
            if (strlen($version) < 3) {
                $task->accepted();

                return;
            }
            if ($dryRun) {
                Yii::info("Fake removing $project-$version");
            } else {
                Yii::info("Removing $project-$version");
                if (is_dir("/home/release/buildroot/$project-$version")) {
                    $commandExecutor->executeCommand("sudo rm -rf /home/release/buildroot/$project-$version");
                }
                try {
                    $commandExecutor->executeCommand("bash bash/rsync/remove.sh $project $version");
                } catch (CommandExecutorException $e) {
                    if ($e->getCode() != 1) {
                        // an: Код 1 - допустим, его игнорируем, значит просто не на всех серверах была установлена эта сборка
                        throw $e;
                    }
                }
                $commandExecutor->executeCommand("reprepro -b /var/www/whotrades_repo/ remove wheezy $project-$version");
                $model->removeReleaseRequest(new Message\RemoveReleaseRequest($project, $version));
            }

            $task->accepted();
        });

        try {
            $model->waitForMessages(null, null, 30);
        } catch (PhpAmqpLib\Exception\AMQPTimeoutException $e) {
            //skip
        }
    }
}
