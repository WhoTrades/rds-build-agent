<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

use RdsSystem\Cron\SingleInstanceController;

class CommandController extends SingleInstanceController
{
    public $user;
    public $projectPath;
    public $package;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['package']);
    }

    /**
     * @param string $user
     * @param string $projectPath
     */
    public function actionIndex($user, $projectPath)
    {
        $this->user = $user;
        $this->projectPath = $projectPath;

        if (realpath($projectPath) == false) {
            throw new \InvalidArgumentException("Path $projectPath not found");
        }

        $list = array_merge(
            $this->getDeployCommands('debian'),
            $this->getDeployCommands('debian-fast'),
            $this->getDeployCommands('just2trade')
        );

        $this->stdout(implode("\n", $list));
    }

    protected function getDeployCommands($workerName)
    {
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

    /**
     * @param string $className
     * @param string $action
     * @param array $params
     * @param string $tagName
     * @param string $interval
     *
     * @return string
     */
    public function createCommand($className, $action, $params, $tagName, $interval = null)
    {
        $interval = $interval ?? '* * * * * *';
        $command = $this->convertCommandClassNameToCommandName($className);

        if ($this->package) {
            $params[] = '--sys__package=' . preg_replace('~-[\d.]+$~', '', $this->package);
        }

        $params[] = '--sys__key=' . $this->getCommandKey($className, $params);

        return "$interval $this->user cd $this->projectPath && php yii.php $command/$action " . implode(" ", $params) . " | logger -p local2.info  -t $tagName";
    }

    private function getCommandKey($className, $parameters)
    {
        return substr(md5($className . ":" . implode(", ", $parameters)), 0, 12);
    }

    private function convertCommandClassNameToCommandName($className)
    {
        $result = preg_replace('~.*\\\~', '', $className);
        $result = preg_replace('~Controller$~', '', $result);
        $result = lcfirst($result);
        $result = preg_replace_callback('~[A-Z]~', function ($match) {
            return '-' . strtolower($match[0]);
        }, $result);

        return $result;
    }
}
