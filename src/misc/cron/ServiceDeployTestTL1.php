<?php
class ServiceDeployTestTL1 extends ServiceDeployProdTL1
{
    /**
     * @return array
     */
    protected function getEnv()
    {
        return [
            'CRONJOB_TOOLS=/home/dev/dev/services/deploy/misc/tools',
        ];
    }
}
