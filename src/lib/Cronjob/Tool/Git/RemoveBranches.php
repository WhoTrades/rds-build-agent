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
        $model  = $this->getMessagingModel($cronJob);
        $instance = $cronJob->getOption('instance');
        $model->readDropBranches(false, function(\RdsSystem\Message\Merge\DropBranches $task) use ($model ,$instance) {
            $branch = $task->branch;

            $this->debugLogger->message("Removing $branch");


            $dir = Cronjob_Tool_Git_Merge::fetchRepositories($this->debugLogger, $instance);

            $this->commandExecutor = new CommandExecutor($this->debugLogger);


            $cmd = "(cd $dir; node git-tools/alias/git-all.js '(git ls-remote --exit-code origin refs/heads/$branch 2>&1 > /dev/null; if [ $? -eq 2 ]; then exit 0; else git push origin :$branch; fi)')";
            $this->commandExecutor->executeCommand($cmd);

            $this->debugLogger->debug("Sending reply with branch=$branch...");
            $model->sendDroppedBranches(new Message\Merge\DroppedBranches($branch));

            $this->debugLogger->message("Branch was removed, task accepted");
            $task->accepted();
        });

        $this->waitForMessages($model, $cronJob);
    }
}