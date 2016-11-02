<?php
/**
 * @author Artem Naumenko
 */

use \Cronjob\ConfigGenerator\CronCommand;
use \Cronjob\ConfigGenerator\MultiCronCommand;

class ServiceDeployDevTL1 extends ServiceDeployTestTL1
{
    /**
     * @return array
     */
    public function getCronConfigRows()
    {
        return array_merge(
            parent::getCronConfigRows(),
            (new MultiCronCommand([
                new CronCommand(\Cronjob_Tool_PDev_Manager::getToolCommand(['--max-duration=86400'], $verbosity = 3), '* * * * * *', 'deploy_switch_branches'),
            ]))->getCronConfigRows()
        );
    }
}
