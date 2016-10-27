<?php
use \Cronjob\ConfigGenerator;
use \Cronjob\ConfigGenerator\Comment;
use \Cronjob\ConfigGenerator\MultiCronCommand;
use \Cronjob\ConfigGenerator\CronCommand;

class ServiceDeployProdTL1
{
    protected $mergeInstanceCount = 1;

    /**
     * @return array
     */
    public function getCronConfigRows()
    {
        $allCommands = [
            new CronCommand(\Cronjob_Tool_Deploy_HardMigrationProxy::getToolCommand(['--max-duration=300'], $verbosity = 3), '* * * * * *', 'deploy_hard_migration_proxy'),

            new Comment("Обслуживание, удаление мусора и т.д."),
            new CronCommand(\Cronjob_Tool_Deploy_GarbageCollector::getToolCommand([], $verbosity = 3), '12 20 0 * * *', 'DeployGarbageCollector'),
            new CronCommand(\Cronjob_Tool_Maintenance_ToolRunner::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', 'deploy_maintenance_runner'),
            new CronCommand(
                \Cronjob_Tool_Git_RemoveBranches::getToolCommand(['--max-duration=60', '--instance=1', '--workerName=debian'], $verbosity = 3),
                '* * * * * *',
                'deploy_remove_branches'
            ),

            new Comment("Git merge"),
            new CronCommand(
                \Cronjob_Tool_Git_Merge::getToolCommand(['--max-duration=60', '--workerName=debian', '--instance=0'], $verbosity = 2),
                '* * * * * *',
                'deploy_git_merge'
            ),
        ] + $this->getDeployCommands('debian') + $this->getDeployCommands('just2trade') + $this->getDeployCommands('debian-fasts');

        $allCommands = new MultiCronCommand($allCommands);

        $rows = $allCommands->getCronConfigRows();

        return array_merge($this->getEnv(), $rows);
    }

    private function getDeployCommands($workerName)
    {
        $commands = [
            new Comment("Сборка $workerName"),
            new CronCommand(\Cronjob_Tool_Deploy_Deploy::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', "deploy_deploy_$workerName"),
            new CronCommand(\Cronjob_Tool_Deploy_Use::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', "deploy_use_$workerName"),
            new CronCommand(\Cronjob_Tool_Deploy_Killer::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', "deploy_killer_$workerName"),

            new Comment("Миграции $workerName"),
            new CronCommand(\Cronjob_Tool_Deploy_Migration::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', "deploy_migration_$workerName"),
            new CronCommand(\Cronjob_Tool_Deploy_HardMigration::getToolCommand(['--max-duration=60'], $verbosity = 3), '* * * * * *', "deploy_hard_migration_$workerName"),
        ];

        return $commands;
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
