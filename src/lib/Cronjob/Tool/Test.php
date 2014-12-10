<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Test -vv
 */

use RdsSystem\Message;

class Cronjob_Tool_Test extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model  = $this->getMessagingModel($cronJob);
        $id = uniqid();
        $model->sendMergeTask(new Message\Merge\Task($id, "feature/WTTES-6", "master"));
    }
}

