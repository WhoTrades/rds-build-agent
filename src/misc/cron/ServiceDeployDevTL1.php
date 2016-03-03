<?php
/**
 * @author Artem Naumenko
 */

use \Cronjob\ConfigGenerator\CronCommand;

class ServiceDeployDevTL1 extends ServiceDeployTestTL1
{
    /**
     * @return array
     */
    public function getCronConfigRows()
    {
        return array_merge(
            parent::getCronConfigRows(),
            [
                new CronCommand(\Cronjob_Tool_PDev_Manager::getToolCommand(['--max-duration=86400'], $verbosity = 3), '* * * * * *', 'deploy_switch_branches'),
            ]
        );
    }
}
