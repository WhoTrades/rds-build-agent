<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\CommandExecutor;
use Yii;
use PhpAmqpLib;
use whotrades\RdsSystem\Message;

class GarbageCollectorController extends RabbitListener
{
    /**
     * @param bool $dryRun - remove packages or just print packages to remove
     */
    public $dryRun = false;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['dryRun']);
    }

    /**
     * @param string $workerName - имя обработчика
     */
    public function actionIndex($workerName)
    {
        $model  = $this->getMessagingModel();
        $commandExecutor = new CommandExecutor();

        $model->readDropReleaseRequest($workerName, true, function (Message\DropReleaseRequest $task) use ($model, $commandExecutor) {
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

            if ($this->dryRun) {
                Yii::info("Fake removing $project-$version");
            } else {
                $env = [
                    'projectName' => $project,
                    'version' => $version,
                ];
                $removeNewScriptFilename = "/tmp/remove-release-request" . uniqid() . ".sh";

                Yii::info("Removing $project-$version, scriptFileName=$removeNewScriptFilename, env=" . json_encode($env));
                file_put_contents($removeNewScriptFilename, $task->scriptRemove);
                chmod($removeNewScriptFilename, 0777);

                $commandExecutor->executeCommand("$removeNewScriptFilename 2>&1", $env);
                unlink($removeNewScriptFilename);
                $model->removeReleaseRequest(new Message\RemoveReleaseRequest($project, $version));
            }

            Yii::info("Task finished");
        });

        $this->waitForMessages($model);
    }
}
