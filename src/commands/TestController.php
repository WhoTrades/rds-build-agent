<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

use app\modules\Wtflow\models\MergeTask;
use RdsSystem\Cron\RabbitListener;
use RdsSystem\Message\Merge\CreateBranch;
use RdsSystem\Message\Merge\DropBranches;
use RdsSystem\Message;
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
