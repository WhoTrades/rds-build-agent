<?php
use \Cronjob\ConfigGenerator\MultiCronCommand;

class ServiceDeployProdTL2 extends ServiceDeployProdTL1
{
    /**
     * @return array
     */
    public function getCronConfigRows()
    {
        $allCommands = [];

        $allCommands = array_merge($allCommands, $this->getDeployCommands('just2trade'));

        $allCommands = new MultiCronCommand($allCommands);

        $rows = $allCommands->getCronConfigRows();

        return array_merge($this->getEnv(), $rows);
    }

    protected function getEnv()
    {
        return [
            'MAILTO=adm+ny_cron@whotrades.org',
            'CRONJOB_TOOLS=/var/www/service-deploy/misc/tools',
            'PATH=/usr/local/bin:/usr/bin:/bin',
            'TERM=xterm',
        ];
    }
}
