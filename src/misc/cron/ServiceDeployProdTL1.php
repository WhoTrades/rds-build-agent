<?php
use \Cronjob\ConfigGenerator;
use \Cronjob\ConfigGenerator\Comment;
use \Cronjob\ConfigGenerator\MultiCronCommand;
use \Cronjob\ConfigGenerator\CronCommand;
use \Cronjob\ConfigGenerator\SimpleCommand;
use \Cronjob\ConfigGenerator\MultiCommandToCron;

class ServiceDeployProdTL1
{
    protected $mergeInstanceCount = 1;

    public function getCronConfigRows()
    {
        $allCommands = [
            new Comment("Сборка"),
            new CronCommand(\Cronjob_Tool_Deploy_Deploy::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_deploy'),
            new CronCommand(\Cronjob_Tool_Deploy_Use::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_use'),
            new CronCommand(\Cronjob_Tool_Deploy_Killer::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_killer'),

            new Comment("Миграции"),
            new CronCommand(\Cronjob_Tool_Deploy_Migration::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_migration'),
            new CronCommand(\Cronjob_Tool_Deploy_HardMigration::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_hard_migration'),
            new CronCommand(\Cronjob_Tool_Deploy_HardMigrationProxy::getToolCommand(['--max-duration=300'], $verbosity=3), '* * * * * *', 'deploy_hard_migration_proxy'),

            new Comment("Обслуживание, удаление мусора и т.д."),
            new CronCommand(\Cronjob_Tool_Deploy_GarbageCollector::getToolCommand([], $verbosity=3), '12 20 0 * * *', 'DeployGarbageCollector'),
            new CronCommand(\Cronjob_Tool_Maintenance_ToolRunner::getToolCommand(['--max-duration=60'], $verbosity=3), '* * * * * *', 'deploy_maintenance_runner'),
            new CronCommand(\Cronjob_Tool_Git_RemoveBranches::getToolCommand(['--max-duration=60 --instance=1'], $verbosity=3), '* * * * * *', 'deploy_remove_branches'),
            new CronCommand(\Cronjob_Tool_PDev_Manager::getToolCommand([], $verbosity = 3), '* * * * * *', 'deploy_switch_branches'),

            new Comment("Git merge"),
            new CronCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=0'], $verbosity=2),'* * * * * *', 'deploy_git_merge'),
//            new CronCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=0 --allowed-branches=develop'], $verbosity=2), '* * * * * *', 'deploy_git_merge-develop'),
//            new CronCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=1 --allowed-branches=staging'], $verbosity=2), '* * * * * *', 'deploy_git_merge-staging'),
//            new CronCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=2 --allowed-branches=master'], $verbosity=2), '* * * * * *', 'deploy_git_merge-master'),
//            new CronCommand(\Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--instance=3 --disallowed-branches=develop,staging,master'], $verbosity=2), '* * * * * *', 'deploy_git_merge-builds'),
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
