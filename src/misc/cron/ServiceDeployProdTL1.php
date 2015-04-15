<?php
use \Cronjob\ConfigGenerator;
use \Cronjob\ConfigGenerator\Comment;
use \Cronjob\ConfigGenerator\MultiCronCommand;
use \Cronjob\ConfigGenerator\CronCommand;
use \Cronjob\ConfigGenerator\SimpleCommand;
use \Cronjob\ConfigGenerator\PeriodicCommand;
use \Cronjob\ConfigGenerator\MultiCommandToCron;
use \Cronjob\ConfigGenerator\MultiPeriodicCommand;

class ServiceDeployProdTL1
{
    protected $mergeInstanceCount = 1;

    public function getCronConfigRows()
    {
        $allCommands = [
            new Comment("Сборка"),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_Deploy::getToolCommand(['--max-duration=60'], $verbosity=3), 5), '* * * * *', 'DeployDeploy'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_Use::getToolCommand(['--max-duration=60'], $verbosity=3), 1), '* * * * *', 'DeployUse'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_Killer::getToolCommand(['--max-duration=60'], $verbosity=3), 3), '* * * * *', 'DeployKiller'),

            new Comment("Миграции"),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_Migration::getToolCommand(['--max-duration=60'], $verbosity=3), 3), '* * * * *', 'DeployMigration'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_HardMigration::getToolCommand(['--max-duration=60'], $verbosity=3), 1), '* * * * *', 'DeployHardMigration'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Deploy_HardMigrationProxy::getToolCommand(['--max-duration=300'], $verbosity=3), 0), '* * * * *', 'DeployHardMigration'),

            new Comment("Обслуживание, удаление мусора и т.д."),
            new CronCommand(\Cronjob_Tool_Deploy_GarbageCollector::getToolCommand([], $verbosity=3), '20 0 * * *', 'DeployGarbageCollector'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Maintenance_ToolRunner::getToolCommand(['--max-duration=60'], $verbosity=3), 0), '* * * * *', 'DeployMaintenance_ToolRunner'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Git_RemoveBranches::getToolCommand(['--max-duration=60 --instance=1'], $verbosity=3), 0), '* * * * *', 'DeployRemoveBranches'),

            new Comment("Git merge"),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=0 --allowed-branches=develop'], $verbosity=2), 0), '* * * * *', 'DeployGitMerge-develop'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=1 --allowed-branches=staging'], $verbosity=2), 0), '* * * * *', 'DeployGitMerge-staging'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=2 --allowed-branches=master'], $verbosity=2), 0), '* * * * *', 'DeployGitMerge-master'),
            new CronCommand(new PeriodicCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=3 --disallowed-branches=develop,staging,master'], $verbosity=2), 0), '* * * * *', 'DeployGitMerge-builds'),
        ];

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