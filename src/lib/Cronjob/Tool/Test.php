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
        $model = $this->getMessagingModel($cronJob);
        $model->sendBuildPatch(
            new Message\ReleaseRequestBuildPatch('comon', '68.00.046.249', file_get_contents('/home/an/log.txt'))
        );
    }
}

