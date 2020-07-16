<?php
/**
 * @author Artem Naumenko
 * @author Maksim Rodikov
 * @example php yii.php use/index debian
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsBuildAgent\services\Deploy\Exceptions\UseConfigLocalErrorException;
use whotrades\RdsBuildAgent\services\Deploy\Exceptions\UseProjectVersionErrorException;
use whotrades\RdsBuildAgent\services\DeployService;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\Message;
use \whotrades\RdsSystem\Message\UseTask;

class UseController extends RabbitListener
{
    /** @var DeployService */
    private $deployService;

    public function __construct($id, $module, $config = [], DeployService $deployService)
    {
        $this->deployService = $deployService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $model = $this->getMessagingModel();

        $model->getUseTask($workerName, false, function (UseTask $task) use ($workerName, $model) {
            try {
                $output = $this->deployService->useProjectVersion($task);
                $model->sendUsedVersion(
                    new Message\ReleaseRequestUsedVersion($workerName, $task->project, $task->version, $task->initiatorUserName, $output)
                );
            } catch (UseProjectVersionErrorException $e) {
                $model->sendUseError(
                    new Message\ReleaseRequestUseError($e->getReleaseRequestId(), $e->getInitiatorUserName(), $e->getMessage())
                );
            }

        });

        $model->readProjectConfig($workerName, false, function (Message\ProjectConfig $task) use ($model) {
            try {
                $output = $this->deployService->useProjectConfigLocal($task);
            } catch (UseConfigLocalErrorException $e) {
                $output = $e->getMessage();
            }

            $model->sendProjectConfigResult(
                new Message\ProjectConfigResult($task->projectConfigHistoryId, $output)
            );
        });

        $this->waitForMessages($model);
    }
}
