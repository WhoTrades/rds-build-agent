<?php
use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Git_Merge -vv
 */
class Cronjob_Tool_Git_Merge extends RdsSystem\Cron\RabbitDaemon
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
        $model->readMergeTask(false, function(\RdsSystem\Message\Merge\Task $task) use ($model ,$instance) {
            $sourceBranch = $task->sourceBranch;
            $targetBranch = $task->targetBranch;

            $this->debugLogger->message("Merging $sourceBranch to $targetBranch");

            $dir = Config::getInstance()->mergePoolDir.$instance;

            $this->debugLogger->message("Pool dir: $dir");
            if (!is_dir($dir)) {
                $this->debugLogger->message("Creating directory $dir");
                mkdir($dir, 0777, true);
            }

            $this->commandExecutor = new CommandExecutor($this->debugLogger);

            $errors = [];
            $repositories = $this->getAllRepositories();
            foreach ($repositories as $key => $url) {
                $this->debugLogger->message("Processing repository $key ($url)");
                $repoDir = $dir."/".$key;

                if (!is_dir($repoDir)) {
                    $this->debugLogger->message("Creating directory $repoDir");
                    mkdir($repoDir, 0777, true);
                }

                if (is_dir($repoDir."/.git")) {
                    $this->debugLogger->debug("Repository $key already exists as $repoDir, fetching changes");
                    $cmd = "(cd $repoDir; git fetch)";
                    $this->commandExecutor->executeCommand($cmd);
                } else {
                    $this->debugLogger->debug("Repository $key not exists as $repoDir, start cloning...");
                    mkdir($repoDir, 0777);
                    $cmd = "(cd $repoDir; git clone $url .)";
                    $this->commandExecutor->executeCommand($cmd);
                }

                $this->debugLogger->message("Cleaning repository $key ($url)");
                $repoDir = $dir."/".$key;
                $cmd = "(cd $repoDir; git reset origin/master --hard)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git clean -fd)";
                $this->commandExecutor->executeCommand($cmd);


                $cmd = "(cd $repoDir; git show-branch origin/$sourceBranch)";
                try {
                    $this->commandExecutor->executeCommand($cmd);
                } catch (\RdsSystem\lib\CommandExecutorException $e) {
                    //an: исходной ветки, значит ничего не мержим
                    $this->debugLogger->warning("Source branch $sourceBranch not found at repository $key");
                    continue;
                }
                $cmd = "(cd $repoDir; git checkout $sourceBranch)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git reset origin/$sourceBranch --hard)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git clean -fd)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git pull)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $repoDir; git checkout $targetBranch)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git reset origin/$targetBranch --hard)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git clean -fd)";
                $this->commandExecutor->executeCommand($cmd);
                $cmd = "(cd $repoDir; git pull)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $repoDir; git merge $sourceBranch)";
                try {
                    $this->commandExecutor->executeCommand($cmd);
                } catch (\RdsSystem\lib\CommandExecutorException $e) {
                    if ($e->getCode() == 1) {
                        //an: Ошибка мержа
                        $this->debugLogger->message("Conflict detected, $e->output");
                        $errors[] = "Conflict at repository $key: $e->output";
                    }
                }
            }

            if (empty($errors)) {
                $this->debugLogger->message("No errors during merge, pushing changes");
                foreach ($repositories as $key => $url) {
                    $this->debugLogger->message("Processing repository $key ($url)");
                    $repoDir = $dir."/".$key;
                    $cmd = "(cd $repoDir; git pull)";
                    $this->commandExecutor->executeCommand($cmd);
                    $cmd = "(cd $repoDir; git push)";
                    $this->commandExecutor->executeCommand($cmd);
                }
            } else {
                $this->debugLogger->message("Merge errors detected, skip pushing");
            }

            $this->debugLogger->debug("Sending reply with id=$task->featureId...");
            $model->sendMergeTaskResult(new Message\Merge\TaskResult($task->featureId, $task->sourceBranch, $task->targetBranch, empty($errors), $errors));

            $this->debugLogger->message("Task accepted");
            $task->accepted();
        });

        $model->waitForMessages();
    }


    private function getAllRepositories()
    {
        $url = "http://git.whotrades.net/packages.json";
        $httpSender = new \ServiceBase\HttpRequest\RequestSender($this->debugLogger);
        $json = $httpSender->getRequest($url, '', self::PACKAGES_TIMEOUT);
        $data = json_decode($json, true);
        if (empty($data)) {
            throw new ApplicationException("Invalid or empty json received from $url: $json");
        }
        $result = [];
        foreach ($data['packages'] as $key => $val) {
            if (0 !== strpos($key, 'whotrades.com')) {
                continue;
            }

            $result[str_replace('whotrades.com/', '', $key)] = $val['dev-master']['source']['url'];
        }

        return $result;
    }
}