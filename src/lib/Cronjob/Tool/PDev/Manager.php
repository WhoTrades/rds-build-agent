<?php
/**
 * Это тул занимается переключением ветки персонального контура на другую
 *
 * @example dev/services/deploy/misc/tools/runner.php --tool=PDev_Manager -vv
 */

use RdsSystem\lib\CommandExecutor;
use RdsSystem\Message\PDev\SwitchBranch;
use RdsSystem\Model\Rabbit\MessagingRdsMs;

class Cronjob_Tool_PDev_Manager extends RdsSystem\Cron\RabbitDaemon
{
    /** @var MessagingRdsMs */
    private $model;

    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }

    /**
     * @param \Cronjob\ICronjob $cronJob
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $this->debugLogger->message("Starting work");

        $this->model = $this->getMessagingModel($cronJob);

        $this->model->readPDevSwitchBranch(true, function (SwitchBranch $task) {
            $path = $task->path;
            $branch = $task->branch;

            // an: Задачу сразу помечаем как выполненную, так как её проще пересоздать, чем исправлять поломанную очередь
            $task->accepted();

            if (empty($branch)) {
                $this->debugLogger->dump()->message('an', "Invalid branch `$branch`", true)->critical()->save();

                return;
            }

            if (!is_dir($path)) {
                $this->debugLogger->dump()->message('an', "Invalid path `$path`", true)->critical()->save();

                return;
            }

            $commandExecutor = new CommandExecutor($this->debugLogger);

            $command = "(cd $path && git fetch)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git checkout .)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git reset .)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git checkout .)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git clean -fd)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git checkout $branch)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git reset origin/$branch --hard)";
            $commandExecutor->executeCommand($command);

            $command = "(cd $path && git clean -fd)";
            $commandExecutor->executeCommand($command);
        });

        $this->debugLogger->message("Successfully finished working");
    }
}
