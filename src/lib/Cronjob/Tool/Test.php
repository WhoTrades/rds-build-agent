<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Test -vv
 */

use RdsSystem\Message;

class Cronjob_Tool_Test extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [
            'test' => [
                'desc' => '',
                'useForBaseName' => true,
                'valueRequired' => true,
            ],
        ] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
//        $semaphore = new \Semaphore($this->debugLogger, \Config::getInstance()->semaphore_dir."/merge_deploy.smp");
//        $semaphore->lock();
//        $this->debugLogger->message("Locked");
//        sleep(10000);
        $model = $this->getMessagingModel($cronJob);
        $model->sendMergeTask(new Message\Merge\Task(1, "master", "master"));
    }
}

