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
            try {
                $repositories = $this->getAllRepositories();
                foreach ($repositories as $key => $url) {
                    $this->debugLogger->debug("Processing repository $key ($url)");
                    $repoDir = $dir . "/" . $key;

                    if (!is_dir($repoDir)) {
                        $this->debugLogger->message("Creating directory $repoDir");
                        mkdir($repoDir, 0777, true);
                    }

                    if (!is_dir($repoDir . "/.git")) {
                        $this->debugLogger->debug("Repository $key not exists as $repoDir, start cloning...");
                        mkdir($repoDir, 0777);
                        $cmd = "(cd $repoDir; git clone $url .)";
                        $this->commandExecutor->executeCommand($cmd);
                    }
                }
                $cmd = "(cd $dir; node git-tools/alias/git-all.js git fetch)";
                $this->commandExecutor->executeCommand($cmd);

                //an: clean up
                $cmd = "(cd $dir; node git-tools/alias/git-all.js rm -fr .git/rebase-apply)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git reset origin/master --hard)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git checkout master)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git reset origin/master --hard)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git clean -fd)";
                $this->commandExecutor->executeCommand($cmd);

                //an: source branch
                $cmd = "(cd $dir; node git-tools/alias/git-all.js \"git checkout $task->sourceBranch || git checkout -b $task->sourceBranch\")";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "cd $dir && node git-tools/alias/git-all.js \"git rev-parse --abbrev-ref $task->sourceBranch@{upstream} || (echo 'pushing branch' && git push -u origin $task->sourceBranch:$task->sourceBranch)\"";
                exec($cmd, $output, $returnVar);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git reset origin/$task->sourceBranch --hard)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git pull --fast)";
                $this->commandExecutor->executeCommand($cmd);

                //: target branch
                $cmd = "(cd $dir; node git-tools/alias/git-all.js \"git checkout $task->targetBranch || git checkout -b $task->targetBranch\")";
                $this->commandExecutor->executeCommand($cmd);


                $cmd = "cd $dir && node git-tools/alias/git-all.js \"git rev-parse --abbrev-ref $task->targetBranch@{upstream} || (echo 'pushing branch' && git push -u origin $task->targetBranch:$task->targetBranch)\"";
                exec($cmd, $output, $returnVar);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git reset origin/$task->targetBranch --hard)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git pull --fast)";
                $this->commandExecutor->executeCommand($cmd);

                $cmd = "(cd $dir; node git-tools/alias/git-all.js git merge $task->sourceBranch)";

                try {
                    $this->commandExecutor->executeCommand($cmd);
                } catch (\RdsSystem\lib\CommandExecutorException $e) {
                    if ($e->getCode() == 1) {
                        //an: Ошибка мержа
                        $this->debugLogger->message("Conflict detected, $e->output");
                        $errors[] = "Conflicts detected: $e->output";
                    }
                }
            } catch (\RdsSystem\lib\CommandExecutorException $e) {
                $this->debugLogger->message("Unknown error during merge, $e->output");
                $errors[] = "Unknown error during merge: $e->output";
            }


            if (empty($errors)) {
                try {
                    $this->debugLogger->message("No errors during merge, pushing changes");
                    $cmd = "(cd $dir; node git-tools/alias/git-all.js git push)";
                    $this->commandExecutor->executeCommand($cmd);
                } catch (\RdsSystem\lib\CommandExecutorException $e) {
                    $this->debugLogger->message("Unknown error during pushing merge: $e->output");
                    $errors[] = "Unknown error during pushing merge: $e->output";
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

    private function checkoutBranchOrBranchFromMaster($dir, $branch)
    {
        $cmd = "(cd $dir; node git-tools/alias/git-all.js git checkout master)";
        $this->commandExecutor->executeCommand($cmd);

        //an: переключаемся в конечный бранч, делаем пулл
        $cmd = "(cd $dir; node git-tools/alias/git-all.js git checkout $branch || git checkout -b $branch)";
        $this->commandExecutor->executeCommand($cmd);

        //an: creating new branch, if not exists at origin
        $cmd = "cd ".Config::$projectPath." && node git-tools/alias/git-all.js \"git rev-parse --abbrev-ref $branch@{upstream} || (git push -u origin $branch:$branch)\"";
        exec($cmd, $output, $returnVar);

        $cmd = "(cd $dir; node git-tools/alias/git-all.js git reset)";
        $this->commandExecutor->executeCommand($cmd);

        $cmd = "(cd $dir; node git-tools/alias/git-all.js git pull --fast)";
        $this->commandExecutor->executeCommand($cmd);
    }
}