<?php
class DeployDevTL1 extends DeployProdTL1
{
   protected function getEnv()
    {
        return [
            'CRONJOB_TOOLS=/home/an/dev/services/deploy/misc/tools',
        ];
    }
}