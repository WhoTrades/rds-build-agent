<?php
class ServiceDeployDevTL1 extends ServiceDeployTestTL1
{
   protected function getEnv()
    {
        return [
            'CRONJOB_TOOLS=/home/an/dev/services/deploy/misc/tools',
        ];
    }
}