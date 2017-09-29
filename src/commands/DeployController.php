<?php
/**
 * @author Artem Naumenko
 */

namespace app\commands;

use app\commands\Exception\StopBuildTask;
use RdsSystem\Cron\RabbitListener;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;
use Yii;
use RdsSystem\Message;

class DeployController extends RabbitListener
{
    private $gid;
    private $taskId;
    private $version;

    /** @var \RdsSystem\Model\Rabbit\MessagingRdsMs */
    private $model;

    /** @var \RdsSystem\Message\BuildTask */
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
            Yii::info("Task received: " . json_encode($task, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            try {
                $this->processBuildTask($task, $workerName);
            } catch (StopBuildTask $e) {
                $this->currentTask->accepted();
            }
        });

        $this->waitForMessages($this->model);
    }

    private function processBuildTask(Message\BuildTask $task, $workerName)
    {
        posix_setpgid(posix_getpid(), posix_getpid());
        $project = $task->project;
        $this->taskId = $taskId = $task->id;
        $this->version = $version = $task->version;
        $release = $task->release;

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
            $currentOperation = "building";
            $this->processBuildProject($projectDir, $task->scriptBuild, $project, $version, $release, $taskId);

            $currentOperation = "get_migrations_list";
            $this->processMigrations($projectDir, $task->scriptMigrationNew, $project, $version);

            // an: Раскладываем собранный проект по серверам
            $currentOperation = "installing";
            $text = $this->processDeploy($projectDir, $task->scriptDeploy, $project, $version, $task->getProjectServers());

            // an: Отправляем новые сгенерированные cron.d конфиги
            $currentOperation = "gen-cron-configs";
            $cronConfig = $this->processGenCronConfis($task->scriptCron, $project, $version);

            $this->model->sendCronConfig(
                new Message\ReleaseRequestCronConfig($taskId, $cronConfig)
            );
            // an: Сигнализируем все что сделали
            $this->sendStatus('installed', $version, $text);
        } catch (CommandExecutorException $e) {
            $text = $e->output;
            Yii::error("Last command: " . $e->getCommand());
            Yii::error("Failed to execute '$currentOperation'");
            $buildLog = "Failed to execute " . $e->getCommand() . "\n";
            $buildLog .= "Command output " . $text . "\n";
            $this->sendStatus('failed', $version, $buildLog);
        } catch (StopBuildTask $e) {
            throw $e;
        } catch (\Exception $e) {
            Yii::error("Unknown error: " . $e->getMessage());
            $this->sendStatus('failed', $version, $e->getMessage());
        }

        Yii::info("Accepting message $task->deliveryTag");
        $task->accepted();

        Yii::info("Restoring pgid");
        posix_setpgid(posix_getpid(), $this->gid);
    }

    private function processGenCronConfis($scriptCron, string $project, string $version)
    {
        if (empty($scriptCron)) {
            Yii::info("No cron generate script detected - so no cron configs");

            return "";
        }
        $commandExecutor = new CommandExecutor();
        $env = [
            'projectName' => $project,
            'version' => $version,
        ];

        $cronScriptFilename = "/tmp/cron-script-" . uniqid() . ".sh";
        file_put_contents($cronScriptFilename, str_replace("\r", "", $scriptCron));
        chmod($cronScriptFilename, 0777);

        $cronConfig = $commandExecutor->executeCommand("$cronScriptFilename 2>&1", $env);

        unlink($cronScriptFilename);

        return $cronConfig;
    }

    private function processDeploy(string $projectDir, $scriptDeploy, string $project, string $version, array $servers)
    {
        if (empty($scriptDeploy)) {
            throw new \Exception("Can't deploy project without deployment script");
        }

        $commandExecutor = new CommandExecutor();
        $env = [
            'projectName' => $project,
            'version' => $version,
            'projectDir' => $projectDir,
            'servers' => implode(" ", $servers),
        ];

        $deployScriptFilename = "/tmp/deploy-script-" . uniqid() . ".sh";
        file_put_contents($deployScriptFilename, str_replace("\r", "", $scriptDeploy));
        chmod($deployScriptFilename, 0777);

        $command = "$deployScriptFilename 2>&1";
        $text = $commandExecutor->executeCommand($command, $env);

        unlink($deployScriptFilename);

        return $text;
    }

    private function processBuildProject(string $projectDir, $scriptBuild, string $project, string $version, $release, $taskId)
    {
        if (empty($scriptBuild)) {
            throw new \Exception("No build script detected - can't build");
        }

        // an: Сигнализируем о начале работы
        $this->sendStatus('building');

        $commandExecutor = new CommandExecutor();

        Yii::info("projectDir=$projectDir");
        $buildScriptFilename = "/tmp/build-script-" . uniqid() . ".sh";
        file_put_contents($buildScriptFilename, str_replace("\r", "", $scriptBuild));
        chmod($buildScriptFilename, 0777);
        $env = [
            'projectName' => $project,
            'version' => $version,
            'projectDir' => $projectDir,
            'release' => $release,
            'taskId' => $taskId,
        ];
        $text = $commandExecutor->executeCommand("$buildScriptFilename 2>&1", $env);
        Yii::trace("Output: $text");

        unlink($buildScriptFilename);

        // an: Сигнализируем все что собрали и начинаем раскладывать по серверам
        $this->sendStatus('built', $version, $text);
    }

    private function processMigrations(string $projectDir, $scriptMigrationNew, string $project, string $version)
    {
        if (empty($scriptMigrationNew)) {
            Yii::info("No migration script detected - so no migrations");

            return;
        }
        $commandExecutor = new CommandExecutor();

        Yii::info("projectDir=$projectDir");
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
            Yii::trace("Output: $text");
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
        Yii::info("Task status changed: status=$status, version=$version, attach_length=" . strlen($attach));
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
        Yii::info("Caught signal $signo");
        $this->getMessagingModel()->stopReceivingMessages();

        if ($signo == SIGTERM || $signo == SIGINT) {
            Yii::info("Cancelling...");
            $this->sendStatus('cancelled', $this->version);
            Yii::info("Cancelled...");

            throw new StopBuildTask();
        }

        parent::onTerm($signo);
    }
}
