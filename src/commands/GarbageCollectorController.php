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
     * @param string $receiverName - имя обработчика
     * @param bool $dryRun - remove packages or just print packages to remove
     */
    public function actionIndex($receiverName, $dryRun = null)
    {
        $dryRun = $dryRun ?? true;
        $model  = $this->getMessagingModel();
        $commandExecutor = new CommandExecutor();

        $model->readDropReleaseRequest($receiverName, true, function (Message\DropReleaseRequest $task) use ($model, $dryRun, $commandExecutor) {
            Yii::info("Task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $project = $task->project;
            $version = $task->version;

            if (strlen($project) < 3) {
                Yii::error("Strange project $project, skip it");
                $task->accepted();

                return;
            }
            if (strlen($version) < 3) {
                Yii::error("Strange version $project, skip it");
                $task->accepted();

                return;
            }

            // an: принимаем задачу ещё до выполнения фактического удаления, так как даже если что-то пойдет не так RDS пришлет ещё такой же пакет
            $task->accepted();

            if ($dryRun) {
                Yii::info("Fake removing $project-$version");
            } else {
                $env = [
                    'projectName' => $project,
                    'version' => $version,
                ];
                $removeNewScriptFilename = "/tmp/remove-release-request" . uniqid() . ".sh";

                Yii::info("Removing $project-$version, scriptFileName=$removeNewScriptFilename, env=" . json_encode($env));
                file_put_contents($removeNewScriptFilename, $removeNewScriptFilename);
                $commandExecutor->executeCommand("$removeNewScriptFilename 2>&1", $env);
                $model->removeReleaseRequest(new Message\RemoveReleaseRequest($project, $version));
            }
        });
    }
}
