<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsBuildAgent\modules\Wtflow\models\MergeTask;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\Message\Merge\CreateBranch;
use whotrades\RdsSystem\Message\Merge\DropBranches;
use whotrades\RdsSystem\Message;
use Yii;
use yii\console\Controller;

class TestController extends RabbitListener
{
    public function actionCreate($branch)
    {
        $model  = $this->getMessagingModel();

        $model->sendMergeCreateBranch('debian', new CreateBranch($branch, 'master', false));
    }
    public function actionDrop($branch)
    {
        $model  = $this->getMessagingModel();

        $model->sendDropBranches('debian', new DropBranches($branch));
    }

    public function actionMerge($sourceBranch, $targetBranch)
    {
        $model  = $this->getMessagingModel();

        $model->sendMergeTask('debian', new Message\Merge\Task(null, $sourceBranch, $targetBranch));
    }
}
