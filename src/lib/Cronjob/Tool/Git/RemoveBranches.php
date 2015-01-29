<?php
use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;

/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Git_RemoveBranches -vv
 */
class Cronjob_Tool_Git_RemoveBranches extends RdsSystem\Cron\RabbitDaemon
{
    const PACKAGES_TIMEOUT = 30;

    /** @var CommandExecutor */
    private $commandExecutor;

    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [
            'instance' => [
                'desc' => 'Instance number of process',
                'valueRequired' => true,
                'required' => true,
                'useForBaseName' => true,
                'default' => 1,
            ],
        ] + parent::getCommandLineSpec();
    }

    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        ini_set('memory_limit', '1G');
        $model  = $this->getMessagingModel($cronJob);
        $instance = $cronJob->getOption('instance');
        $model->readDropBranches(false, function(\RdsSystem\Message\Merge\DropBranches $task) use ($model ,$instance) {
            $branch = $task->branch;

            $this->debugLogger->message("Removing $branch");

            $this->commandExecutor = new CommandExecutor($this->debugLogger);

            $dir = Cronjob_Tool_Git_Merge::fetchRepositories($this->debugLogger, $instance);

            $cmd = "(cd $dir; node git-tools/alias/git-all.js git fetch)";
            $this->commandExecutor->executeCommand($cmd);

            $this->commandExecutor = new CommandExecutor($this->debugLogger);

            $skippedRepositories = [];

            $list = glob("$dir/*");
            foreach ($list as $repoDir) {
                $this->debugLogger->info("Processing $repoDir");
                $cmd = "(cd $repoDir; git ls-remote --exit-code origin refs/heads/$branch)";
                try {
                    $this->commandExecutor->executeCommand($cmd);
                } catch (\RdsSystem\lib\CommandExecutorException $e) {
                    if ($e->getCode() == 2) {
                        //an: ветка уже была удалена или не была создана, игнорируем такую ситуацию
                        $this->debugLogger->info("Branch $branch not exists at $repoDir, skip it");
                        continue;
                    }
                    throw $e;
                }

                $cmd = "(cd $repoDir; git log origin/$branch ^origin/master --pretty=format:'%H [%ad] (%an) %s')";
                $output = trim($this->commandExecutor->executeCommand($cmd));
                if (!$output) {
                    $this->debugLogger->info("Removing branch $branch as $repoDir, all commits exists at master branch");
                    //an: Удаляем ветку, все комиты есть в мастере
                    $cmd = "(cd $repoDir; git push origin :$branch)";
                    $this->commandExecutor->executeCommand($cmd);
                } else {
                    //an: есть комиты, не смерженные в мастер. Такие ветки мы не удаляем, но оповещаем RDS о них
                    $this->debugLogger->info("Skip removing branch $branch as $repoDir, some commits not at master: $output");
                    $skippedRepositories[preg_replace('~^.*/~' ,'', $repoDir)] = $output;
                }
            }

            $this->debugLogger->debug("Sending reply with branch=$branch...");
            $model->sendDroppedBranches(new Message\Merge\DroppedBranches($branch, $skippedRepositories));

            $this->debugLogger->message("Branch was removed, task accepted");
            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}