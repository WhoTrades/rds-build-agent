<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

use whotrades\RdsBuildAgent\commands\Exception\StopBuildTask;
use whotrades\RdsSystem\Cron\RabbitListener;
use whotrades\RdsSystem\lib\CommandExecutor;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use Yii;
use whotrades\RdsSystem\Message;

class DeployController extends RabbitListener
{
    const MIGRATION_TYPE_PRE = 'pre';
    const MIGRATION_TYPE_POST = 'post';
    const MIGRATION_TYPE_HARD = 'hard';

    const MIGRATION_COMMAND_NEW_ALL = 'new all';

    const CURRENT_OPERATION_BUILDING = 'building';
    const CURRENT_OPERATION_GET_MIGRATIONS_LIST = 'get_migrations_list';
    const CURRENT_OPERATION_GEN_CRON_CONFIGS = 'gen_cron_configs';
    const CURRENT_OPERATION_INSTALLING = 'installing';
    const CURRENT_OPERATION_POST_INSTALL_SCRIPT = 'post_install_script';

    private $gid;
    private $taskId;
    private $version;

    /** @var \whotrades\RdsSystem\Model\Rabbit\MessagingRdsMs */
    private $model;

    /** @var \whotrades\RdsSystem\Message\BuildTask */
    private $currentTask;

    /**
     * @param string $workerName
     */
    public function actionIndex($workerName)
    {
        $this->model  = $this->getMessagingModel();
        $this->gid = posix_getpgid(posix_getpid());

        $this->model->getBuildTask($workerName, false, function (Message\BuildTask $task) use ($workerName) {
            $this->currentTask = $task;
            Yii::info("Build task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            $this->processTask($task, $workerName);
        });

        $this->model->getInstallTask($workerName, false, function (Message\InstallTask $task) use ($workerName) {
            $this->currentTask = $task;
            Yii::info("Install task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            $this->processTask($task, $workerName);
        });

        try {
            $this->waitForMessages($this->model);
        } catch (StopBuildTask $e) {
        }
    }

    /**
     * @param Message\DeployTaskBase $task
     * @param string $workerName
     *
     * @throws StopBuildTask
     */
    private function processTask(Message\DeployTaskBase $task, $workerName)
    {
        posix_setpgid(posix_getpid(), posix_getpid());
        $project = $task->project;
        $this->taskId = $taskId = $task->id;
        $this->version = $version = $task->version;
        $release = $task->release;

        if (!file_exists(Yii::$app->params['pidDir'])) {
            mkdir(Yii::$app->params['pidDir'], 0777, true);
        }

        $basePidFilename = Yii::$app->params['pidDir'] . "/{$workerName}_deploy_$taskId.php";
        $pid = posix_getpid();
        Yii::info("My pid: $pid");
        file_put_contents("$basePidFilename.pid", $pid);
        file_put_contents("$basePidFilename.pgid", posix_getpgid(posix_getpid()));

        register_shutdown_function(function () use ($basePidFilename) {
            unlink("$basePidFilename.pid");
            unlink("$basePidFilename.pgid");
        });

        $projectDir = Yii::$app->params['buildDir'] . "/$project-$version";

        try {
            switch (get_class($task)) {
                case Message\BuildTask::class:
                    /** @var Message\BuildTask $task */
                    // an: Сигнализируем о начале работы
                    $this->sendStatus('building');

                    $currentOperation = self::CURRENT_OPERATION_BUILDING;
                    $text = $this->processBuildProject($projectDir, $task->scriptBuild, $project, $version, $release, $taskId);

                    $currentOperation = self::CURRENT_OPERATION_GET_MIGRATIONS_LIST;
                    $this->processMigrations($projectDir, $task->scriptMigrationNew, $project, $version);

                    // an: Отправляем новые сгенерированные cron.d конфиги
                    $currentOperation = self::CURRENT_OPERATION_GEN_CRON_CONFIGS;
                    $cronConfig = $this->processGenCronConfis($task->scriptCron, $project, $version);

                    $this->model->sendCronConfig(
                        new Message\ReleaseRequestCronConfig($taskId, $cronConfig)
                    );

                    // an: Сигнализируем что все сделали
                    $this->sendStatus('built', $version, $text);

                    break;
                case Message\InstallTask::class:
                    /** @var Message\InstallTask $task */
                    // an: Сигнализируем о начале работы
                    $this->sendStatus('installing');

                    // an: Раскладываем собранный проект по серверам
                    $currentOperation = self::CURRENT_OPERATION_INSTALLING;
                    $text = $this->processInstall($projectDir, $task->scriptInstall, $project, $version, $task->getProjectServers());

                    // an: Сигнализируем что все сделали
                    $this->sendStatus('installed', $version, $text);

                    try {
                        $currentOperation = self::CURRENT_OPERATION_POST_INSTALL_SCRIPT;
                        $text = $this->processPostInstall($projectDir, $task->scriptPostInstall, $project, $version);

                        // ag: Сигнализируем что скрипт отработал
                        $this->sendStatus('post_installed', $version, $text);
                    } catch (CommandExecutorException $e) {
                        $this->processCommandExecutorException($e, $currentOperation, $version, 'post_installed');
                    }

                    break;
                default:
                    Yii::error("Unknown deploy task: " . get_class($task));
                    $this->sendStatus('failed', $version);
            }
        } catch (CommandExecutorException $e) {
            $this->processCommandExecutorException($e, $currentOperation, $version, 'failed');
        } catch (StopBuildTask $e) {
            $sigName = $this->mapSigNoToName($e->getSigno());
            Yii::error("Stop processing task with signal $sigName");
            $this->sendStatus('failed', $version, "Processing of task was stopped with signal $sigName");
        } catch (\Exception $e) {
            Yii::error("Unknown error: " . $e->getMessage());
            $this->sendStatus('failed', $version, $e->getMessage());
        }

        Yii::info("Accepting message $task->deliveryTag");
        $task->accepted();

        Yii::info("Restoring pgid");
        posix_setpgid(posix_getpid(), $this->gid);
    }

    /**
     * @param CommandExecutorException $e
     * @param string $currentOperation
     * @param string $version
     * @param string $sendStatus
     */
    private function processCommandExecutorException(CommandExecutorException $e, $currentOperation, $version, $sendStatus)
    {
        $text = $e->output;
        Yii::error("Last command: " . $e->getCommand());
        Yii::error("Failed to execute '$currentOperation'");
        $buildLog = "Failed to execute " . $e->getCommand() . "\n";
        $buildLog .= "Command output " . $text . "\n";
        $this->sendStatus($sendStatus, $version, $buildLog);
    }

    private function processScript($script, $scriptPrefix, array $env)
    {
        $commandExecutor = new CommandExecutor();

        $scriptFilename = $scriptPrefix . uniqid() . ".sh";
        file_put_contents($scriptFilename, str_replace("\r", "", $script));
        chmod($scriptFilename, 0777);

        $result = $commandExecutor->executeCommand("$scriptFilename 2>&1", $env);

        unlink($scriptFilename);

        return $result;
    }

    private function processGenCronConfis($scriptCron, string $project, string $version)
    {
        if (empty($scriptCron)) {
            Yii::info("No cron generate script detected - so no cron configs");

            return "";
        }

        return $this->processScript(
            $scriptCron,
            '/tmp/cron-script-',
            [
                'projectName' => $project,
                'version' => $version,
            ]
        );
    }

    /**
     * @param string $projectDir
     * @param string $scriptInstall
     * @param string $project
     * @param string $version
     * @param array $servers
     *
     * @return string
     *
     * @throws CommandExecutorException
     */
    private function processInstall(string $projectDir, $scriptInstall, string $project, string $version, array $servers)
    {
        if (empty($scriptInstall)) {
            throw new \Exception("Can't install project without installation script");
        }

        return $this->processScript(
            $scriptInstall,
            '/tmp/install-script-',
            [
                'projectName' => $project,
                'version' => $version,
                'projectDir' => $projectDir,
                'servers' => implode(" ", $servers),
            ]
        );
    }


    /**
     * @param string $projectDir
     * @param string $scriptPostInstall
     * @param string $project
     * @param string $version
     *
     * @return string
     *
     * @throws CommandExecutorException
     */
    private function processPostInstall(string $projectDir, $scriptPostInstall, string $project, string $version)
    {
        Yii::info("Start to process post install script");

        if (empty($scriptPostInstall)) {
            Yii::info("Skip processing post install script. It is empty");

            return '';
        }

        return $this->processScript(
            $scriptPostInstall,
            '/tmp/post-install-script-',
            [
                'projectName' => $project,
                'version' => $version,
                'projectDir' => $projectDir,
            ]
        );
    }

    private function processBuildProject(string $projectDir, $scriptBuild, string $project, string $version, $release, $taskId)
    {
        if (empty($scriptBuild)) {
            throw new \Exception("No build script detected - can't build");
        }

        return $this->processScript(
            $scriptBuild,
            '/tmp/build-script-',
            [
                'projectName' => $project,
                'version' => $version,
                'projectDir' => $projectDir,
                'release' => $release,
                'taskId' => $taskId,
            ]
        );
    }

    private function processMigrations(string $projectDir, $scriptMigrationNew, string $project, string $version)
    {
        if (empty($scriptMigrationNew)) {
            Yii::info("No migration script detected - so no migrations");

            return;
        }

        Yii::info("projectDir=$projectDir");
        // an: Проект с миграциями
        $command = self::MIGRATION_COMMAND_NEW_ALL;
        foreach ([self::MIGRATION_TYPE_PRE, self::MIGRATION_TYPE_POST, self::MIGRATION_TYPE_HARD] as $type) {
            $text = $this->processScript(
                $scriptMigrationNew,
                '/tmp/migration-new-script-',
                [
                    'project' => $project,
                    'version' => $version,
                    'type' => $type,
                    'command' => $command,
                ]
            );

            Yii::trace("Output: $text");
            $lines = explode("\n", str_replace("\r", "", $text));
            $migrations = array_filter($lines);
            $migrations = array_map('trim', $migrations);
            $this->model->sendMigrations(
                new Message\ReleaseRequestMigrations($project, $version, $migrations, $type, $command)
            );
        }
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
        Yii::info("Task status changed: status=$status, version=$version, attach_length=" . strlen($attach));
        $this->model->sendTaskStatusChanged(
            new Message\TaskStatusChanged($this->taskId, $status, $version, $attach)
        );
    }

    /**
     * @param int $signo
     *
     * @throws StopBuildTask
     */
    public function onTerm($signo)
    {
        Yii::info("Caught signal " . $this->mapSigNoToName($signo));
        $this->stopReceivingMessages();

        throw new StopBuildTask($signo);
    }
}
