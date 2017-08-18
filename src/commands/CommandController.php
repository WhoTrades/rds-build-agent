<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

class CommandController extends \RdsSystem\commands\CommandController
{
    public $user;
    public $projectPath;
    public $package;
    public $workerName;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['package', 'workerName']);
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        $workerName = $this->workerName;

        return [
            "# Сборка $workerName",
            $this->createCommand(DeployController::class, 'index', [$workerName], "deploy_deploy_$workerName"),
            $this->createCommand(UseController::class, 'index', [$workerName], "deploy_use_$workerName"),
            $this->createCommand(KillerController::class, 'index', [$workerName], "deploy_killer_$workerName"),

            "# Миграции $workerName",
            $this->createCommand(MigrationController::class, 'index', [$workerName], "deploy_migration_$workerName"),
            $this->createCommand(HardMigrationController::class, 'index', [$workerName], "deploy_hard_migration_$workerName"),
            $this->createCommand(HardMigrationProxyController::class, 'index', ['debian'], "deploy_hard_migration_proxy_$workerName"),

            "# Обслуживание, удаление мусора и т.д.",
            $this->createCommand(GarbageCollectorController::class, 'index', ['debian'], 'deploy_garbage_collector', '12 20 * * * *'),
            $this->createCommand(GitDropBranchesController::class, 'index', ['debian'], 'deploy_remove_branches'),
            $this->createCommand(GitMergeController::class, 'index', ['debian'], 'deploy_git_merge'),
        ];
    }
}
