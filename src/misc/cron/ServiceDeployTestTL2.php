<?php
class ServiceDeployTestTL2 extends ServiceDeployProdTL2
{
   protected function getEnv()
    {
        return [
            'CRONJOB_TOOLS=/home/dev/dev/services/deploy/misc/tools',
        ];
    }
}