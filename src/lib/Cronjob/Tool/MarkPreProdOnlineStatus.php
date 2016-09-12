<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=MarkPreProdOnlineStatus -vv --online=1
 */

class Cronjob_Tool_MarkPreProdOnlineStatus extends RdsSystem\Cron\RabbitDaemon
{
    /**
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return array(
            'online' => [
                'desc' => 'Какой статус контура мы хотим отправить, работаем - 1 или лежим - 0',
                'default' => 1,
                'valueRequired' => true,
            ],
        ) + parent::getCommandLineSpec();
    }

    /**
     * @param \Cronjob\ICronjob $cronJob
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model = $this->getMessagingModel($cronJob);
        if ($cronJob->getOption('online')) {
            $this->debugLogger->message("PreProd marked online");
            $model->sendPreProdUp(new \RdsSystem\Message\PreProd\Up());
        } else {
            $this->debugLogger->message("PreProd marked offline");
            $model->sendPreProdDown(new \RdsSystem\Message\PreProd\Down());
        }

        $this->debugLogger->message("Message sent, finished");
    }
}
