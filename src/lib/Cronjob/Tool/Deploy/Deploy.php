<?php
use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

/**
 * @example sphp dev/services/deploy/misc/tools/runner.php --tool=Deploy_Deploy --worker-name=debian -vv
 * @example sphp dev/services/deploy/misc/tools/runner.php --tool=Deploy_Deploy --worker-name=debian-fast -vv
 */
class Cronjob_Tool_Deploy_Deploy extends RdsSystem\Cron\RabbitDaemon
{
    private $gid;
    private $taskId;
    private $version;

    /** @var \RdsSystem\Model\Rabbit\MessagingRdsMs */
    private $model;

    /** @var \RdsSystem\Message\BuildTask */
    private $currentTask;

    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return [
            'worker-name' => [
                'desc' => 'Name of worker',
                'required' => true,
                'valueRequired' => true,
                'useForBaseName' => true,
            ],
        ] + parent::getCommandLineSpec();
    }

    /**
     * @param \Cronjob\ICronjob $cronJob
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $workerName = $cronJob->getOption('worker-name');
        $driver = \Config::getInstance()->driver;
        $this->model  = $this->getMessagingModel($cronJob);
        $this->gid = posix_getpgid(posix_getpid());

        $this->model->getBuildTask($workerName, false, function (\RdsSystem\Message\BuildTask $task) use ($workerName, $driver) {
            $this->currentTask = $task;

            $this->debugLogger->message("Task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            posix_setpgid(posix_getpid(), posix_getpid());
            $commandExecutor = new CommandExecutor($this->debugLogger);
            $project = $task->project;
            $this->taskId = $taskId = $task->id;
            $this->version = $version = $task->version;
            $release = $task->release;
            $lastBuildTag = $task->lastBuildTag;

            $basePidFilename = \Config::getInstance()->pid_dir . "/{$workerName}_deploy_$taskId.php";
            file_put_contents("$basePidFilename.pid", posix_getpid());
            file_put_contents("$basePidFilename.pgid", posix_getpgid(posix_getpid()));

            register_shutdown_function(function () use ($basePidFilename) {
                unlink("$basePidFilename.pid");
                unlink("$basePidFilename.pgid");
            });

            $projectDir = "/home/release/buildroot/$project-$version/var/pkg/$project-$version/";

            if (Config::getInstance()->debug) {
                $projectDir = $project == 'comon'
                    ? "/home/dev/dev/$project/"
                    : "/home/dev/dev/services/" . str_replace("service-", "", $project) . "/";
            }

            $currentOperation = "none";
            try {
                // an: Сигнализируем о начале работы
                $currentOperation = "send status 'building'";
                $this->sendStatus('building');

                $buildDir = "/home/release/build/";
                $buildTmp = "/home/release/buildtmp/";
                $buildRoot = "/home/release/buildroot/$project-$version";
                // an: Собираем проект
                $command = "env VERBOSE=y bash bash/rebuild-package.sh $project $version $release $taskId " .
                    Config::getInstance()->rdsDomain . " " . Config::getInstance()->createTag . " $buildDir $buildTmp $buildRoot 2>&1";

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeRebuild.php $project $version";
                }

                $currentOperation = "building";

                $text = $commandExecutor->executeCommand($command);

                // an: Упаковываем проект в deb/rpm пакет
                $command = "bash bash/$driver/build.sh $project $version $buildTmp $buildRoot 2>&1";

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeRebuild.php $project $version";
                }
                $text .= $commandExecutor->executeCommand($command);

                $output = '';
                // an: хак, для словаря мы ничего не тегаем и патч не отправляем, пока что
                if ($project != 'dictionary') {
                    // an: Отправляем на сервер какие тикеты были в этом билде
                    $currentOperation = "getting_build_patch";
                    $srcDir = "/home/release/build/$project";

                    $mapFilename = "$srcDir/lib/map.txt";

                    if (file_exists($mapFilename)) {
                        $dirs = preg_replace('~\s+~sui', ' ', file_get_contents($mapFilename));
                        if ($lastBuildTag) {
                            $command = "(cd $srcDir/lib/sparta; echo -n '>>> '; git remote -v|tail -n 1; git log $lastBuildTag..$project-$version --pretty='%H|%s|/%an/' $dirs)";
                        } else {
                            $command = "(cd $srcDir/lib/sparta; echo -n '>>> '; git remote -v|tail -n 1; git log $project-$version..HEAD --pretty='%H|%s|/%an/' $dirs)";
                        }
                        if (Config::getInstance()->debug) {
                            $command = "cat /home/an/log.txt";
                        }

                        try {
                            $output = $commandExecutor->executeCommand($command);
                        } catch (CommandExecutorException $e) {
                            // an: 128 - это когда нет какого-то тега в прошлом.
                            //@todo подумать как это корректо обрабатывать такую ситуацию и реализовать
                            $output = $e->output;
                            if ($e->getCode() != 128) {
                                throw $e;
                            }
                        }
                    } else {
                        $this->debugLogger->message("No map.txt found, skip patch sending");
                    }
                }

                $currentOperation = "sending_build_patch";

                $this->debugLogger->message("Sending building patch, length=" . strlen($output));
                $this->model->sendBuildPatch(
                    new Message\ReleaseRequestBuildPatch($project, $version, $output)
                );

                // an: Сигнализируем все что собрали и начинаем раскладывать по серверам
                $this->sendStatus('built', $version, $text);

                $currentOperation = "get_migrations_list";
                $this->processMigrations($projectDir, $task->scriptMigrationNew, $project, $version);

                $currentOperation = "installing";
                // an: Раскладываем собранный проект по серверам
                $command = "bash bash/$driver/publish.sh $project $version 2>&1";

                if (Config::getInstance()->debug) {
                    $command = "php bash/fakeRebuild.php $project $version";
                }
                $text = $commandExecutor->executeCommand($command);

                // an: Отправляем новые сгенерированные /etc/cron.d конфиги
                $cronConfig = "";
                if (Config::getInstance()->debug && $project != 'dictionary') {
                    $command = "(php $projectDir/misc/tools/runner.php --tool=CodeGenerate_CronjobGenerator --project=$project " .
                        "--env=dev --server=1 --package=$project-$version > $projectDir/misc/cronjobs/cronjob-$project-tl1) 2>&1";
                    $commandExecutor->executeCommand($command);

                    $command = "(php $projectDir/misc/tools/runner.php --tool=CodeGenerate_CronjobGenerator --project=$project " .
                        "--env=dev --server=2 --package=$project-$version > $projectDir/misc/cronjobs/cronjob-$project-tl2) 2>&1";
                    $commandExecutor->executeCommand($command);
                }

                foreach (glob("$projectDir/misc/cronjobs/cronjob-*") as $file) {
                    $cronConfig .= "#       " . preg_replace('~^.*/~', '', $file) . "\n\n";
                    $cronConfig .= file_get_contents($file);
                    $cronConfig .= "\n\n";
                }

                $this->model->sendCronConfig(
                    new Message\ReleaseRequestCronConfig($taskId, $cronConfig)
                );
                // an: Сигнализируем все что сделали
                $this->sendStatus('installed', $version, $text);
            } catch (CommandExecutorException $e) {
                $text = $e->output;
                $this->debugLogger->error("Last command: " . $e->getCommand());
                $this->debugLogger->error("Failed to execute '$currentOperation'");
                $buildLog = "Failed to execute " . $e->getCommand() . "\n";
                $buildLog .= "Command output " . $text . "\n";
                $this->sendStatus('failed', $version, $buildLog);
            } catch (Exception $e) {
                $this->debugLogger->error("Unknown error: " . $e->getMessage());
                $this->sendStatus('failed', $version, $e->getMessage());
            }

            $this->debugLogger->message("Accepting message $task->deliveryTag");
            $task->accepted();

            $this->debugLogger->message("Restoring pgid");
            posix_setpgid(posix_getpid(), $this->gid);
        });

        $this->waitForMessages($this->model, $cronJob);
    }

    private function processMigrations(string $projectDir, $scriptMigrationNew, string $project, string $version)
    {
        if (empty($scriptMigrationNew)) {
            $this->debugLogger->message("No migration script detected - so no migrations");

            return;
        }
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $this->debugLogger->message("projectDir=$projectDir");
        $migrationNewScriptFilename = "/tmp/migration-new-script-" . uniqid() . ".sh";
        file_put_contents($migrationNewScriptFilename, str_replace("\r", "", $scriptMigrationNew));
        chmod($migrationNewScriptFilename, 0777);
        // an: Проект с миграциями
        foreach (array('pre', 'post', 'hard') as $type) {
            $env = [
                'projectName' => $project,
                'version' => $version,
                'type' => $type,
                'projectDir' => $projectDir,
            ];
            $text = $commandExecutor->executeCommand("$migrationNewScriptFilename 2>&1", $env);
            $this->debugLogger->debug("Output: $text");
            $lines = explode("\n", str_replace("\r", "", $text));
            $migrations = array_filter($lines);
            $migrations = array_map('trim', $migrations);
            $this->model->sendMigrations(
                new Message\ReleaseRequestMigrations($project, $version, $migrations, $type)
            );
        }

        unlink($migrationNewScriptFilename);
    }

    /**
     * Отправляет на сервер текущий статус сборки на конкретной машине сборщике
     *
     * @param $status
     * @param null $version
     * @param null $attach
     */
    private function sendStatus($status, $version = null, $attach = null)
    {
        $this->debugLogger->message("Task status changed: status=$status, version=$version, attach_length=" . strlen($attach));
        $this->model->sendTaskStatusChanged(
            new Message\TaskStatusChanged($this->taskId, $status, $version, $attach)
        );
    }

    /**
     * @param int $signo
     * @void
     */
    public function onTerm($signo)
    {
        $this->debugLogger->message("Caught signal $signo");
        if ($signo == SIGTERM || $signo == SIGINT) {
            $this->currentTask->accepted();

            $this->debugLogger->message("Cancelling...");
            $this->sendStatus('cancelled', $this->version);
            $this->debugLogger->message("Cancelled...");


            CoreLight::getInstance()->getFatalWatcher()->stop();

            // an: выходим со статусом 0, что бы periodic не останавливался
            exit(0);
        }

        parent::onTerm($signo);
    }
}
