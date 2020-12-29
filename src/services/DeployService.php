<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services;

use samdark\log\PsrMessage;
use whotrades\RdsBuildAgent\services\DeployService\Event\DeployStatusEvent;
use whotrades\RdsBuildAgent\services\DeployService\Event\CronConfigUpdateEvent;
use whotrades\RdsBuildAgent\services\DeployService\Event\MigrationFinishEvent;
use whotrades\RdsBuildAgent\services\DeployService\Event\PostUseFinishEvent;
use whotrades\RdsBuildAgent\services\DeployService\Event\UseFinishEvent;
use whotrades\RdsSystem\lib\CommandExecutor;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\Exception\EmptyAttributeException;
use whotrades\RdsSystem\lib\Exception\FilesystemException;
use whotrades\RdsSystem\lib\Exception\ScriptExecutorException;
use whotrades\RdsSystem\lib\ScriptExecutor;
use whotrades\RdsSystem\Message\BuildTask;
use whotrades\RdsSystem\Message\InstallTask;
use whotrades\RdsSystem\Message\ProjectConfig;
use whotrades\RdsSystem\Message\UseTask;
use Yii;
use yii\base\BaseObject;
use yii\base\Event;

class DeployService extends BaseObject
{
    const EVENT_DEPLOY_STATUS       = 'event.deploy.status';
    const EVENT_MIGRATION_FINISH    = 'event.migration.finish';
    const EVENT_CRON_CONFIG_UPDATE  = 'event.cron.config.finish';
    const EVENT_USE_FINISH          = 'event.use.finish';
    const EVENT_POST_USE_FINISH     = 'event.post_use.finish';

    public const MIGRATION_COMMAND_NEW_ALL = 'new all';
    public const MIGRATION_TYPE_POST = 'post';
    public const MIGRATION_TYPE_PRE = 'pre';
    public const MIGRATION_TYPE_HARD = 'hard';

    /** @var string */
    private $projectDirUniqid;

    /** @var string */
    private $projectBuildRoot;

    public function __construct(string $buildRoot, $config = null)
    {
        $config = $config ?? [];
        $this->projectBuildRoot = $buildRoot;
        $this->setProjectDirUniqid();
        parent::__construct($config);
    }

    /**
     * @param UseTask $task
     *
     * @return void
     *
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     * @throws ScriptExecutorException
     */
    public function useProjectVersion(UseTask $task): void
    {
        $project = $task->project;
        $releaseRequestId = (int) $task->releaseRequestId;
        $version = $task->version;

        Yii::info("Using $project:$version, task_id=$releaseRequestId");

        try {
            if (empty($task->scriptUse)) {
                Yii::error(new PsrMessage("error_use_script_empty", [
                    'projectName' => $project,
                    'version' => $version,
                ]));
                throw new EmptyAttributeException();
            }
            $env = [
                'projectName' => $project,
                'version' => $version,
                'servers' => implode(" ", $task->projectServers),
            ];

            $output = empty($task->scriptUse) ? "" : $this->getScriptExecutor($task->scriptUse, '/tmp/use-script-', $env)();
            Event::trigger(self::class, self::EVENT_USE_FINISH, new UseFinishEvent($task->project, $task->version, $task->initiatorUserName, $output));

            // Post use script
            $env['cron'] = $task->cronConfig;
            $postUseOutput = empty($task->scriptPostUse) ? "" : $this->getScriptExecutor($task->scriptPostUse, '/tmp/post-use-script-', $env)();
            Event::trigger(self::class, self::EVENT_POST_USE_FINISH, new PostUseFinishEvent($task->project, $task->version, $postUseOutput));
        } finally {
            $task->accepted();
        }
    }

    /**
     * @param ProjectConfig $task
     *
     * @return string
     *
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     */
    public function useProjectConfigLocal(ProjectConfig $task): string
    {
        $this->setProjectDirUniqid(); //mr: new uniqid for each run
        Yii::info("Task received: " . json_encode($task));
        $project = $task->project;

        if (empty($task->scriptUploadConfigLocal)) {
            Yii::warning("Skip task, as scriptUploadConfigLocal is empty");
            $task->accepted();
            throw new EmptyAttributeException();
        }

        $projectDir = $this->getProjectDirectoryPath($task->project);
        if (!is_dir($projectDir)) {
            if (!mkdir($projectDir, 0777, true)) {
                $errMessage = "Can't create tmp dir";
                Yii::error(new PsrMessage($errMessage, [
                    'project' => $project,
                    'projectDir' => $projectDir,
                ]));
                $task->accepted();

                throw new FilesystemException($errMessage, FilesystemException::ERROR_WRITE_DIRECTORY);
            }
        }

        foreach ($task->configs as $filename => $content) {
            $filePath = $this->getProjectFilenamePath($task->project, $filename);
            if (false === file_put_contents($filePath, $content)) {
                $errMessage = "Can't save project config";
                Yii::error(new PsrMessage($errMessage, [
                    'project' => $project,
                    'filename' => $filePath,
                    'content' => $content,
                ]));
                $task->accepted();
                throw new FilesystemException($errMessage, FilesystemException::ERROR_WRITE_FILE);
            }
        }

        $tmpScriptFilename = $this->getTemporaryScriptPath($task->project);
        if (false === file_put_contents($tmpScriptFilename, str_replace("\r\n", "\n", $task->scriptUploadConfigLocal))) {
            $errMessage = "Can't save tmp shell script";
            Yii::error(new PsrMessage($errMessage, [
                'project' => $project,
                'filename' => $tmpScriptFilename,
                'content' => $task->scriptUploadConfigLocal,
            ]));
            $task->accepted();
            throw new FilesystemException($errMessage, FilesystemException::ERROR_WRITE_FILE);
        }

        chmod($tmpScriptFilename, 0777); // TODO: Could return false as well

        $env = [
            'projectName' => $project,
            'servers' => implode(" ", $task->getProjectServers()),
            'configDir' => $projectDir,
        ];

        $commandExecutor = $this->getCommandExecutor();

        try {
            $output = $commandExecutor->executeCommand("$tmpScriptFilename 2>&1", $env);
            Yii::debug("Output: " . $output);

            foreach (glob("$projectDir/*") as $file) {
                unlink($file);
            }
            rmdir($projectDir);
            unlink($tmpScriptFilename);

            Yii::info("Sync success");
            $task->accepted();
        } catch (CommandExecutorException $e) {
            $output = $e->getMessage() . "\nOutput: " . $e->output;
            Yii::error(new PsrMessage("error_synchronization_config_local_skip_message", [
                'command' => $e->getCommand(),
                'output' => $e->getOutput(),
                'projectDir' => $projectDir,
                'tmpScriptFilename' => $tmpScriptFilename,
                'task' => [
                    'project' => $task->project,
                    'scriptUploadConfigLocal' => $task->scriptUploadConfigLocal,
                    'configs' => $task->configs,
                    'timeCreated' => $task->timeCreated,
                ],
            ]));

            $task->accepted();
            throw new CommandExecutorException($e->getCommand(), $output, $e->getCode(), $e->getOutput(), $e);
        }

        return $output;
    }

    /**
     * @param BuildTask $task
     *
     * @throws CommandExecutorException
     * @throws FilesystemException
     * @throws ScriptExecutorException|EmptyAttributeException
     */
    public function deployBuild(BuildTask $task)
    {
        $projectBuildDir = $this->getProjectBuildDirPath($task->project, $task->version);
        // an: Сигнализируем о начале работы
        Event::trigger(self::class, self::EVENT_DEPLOY_STATUS, new DeployStatusEvent(DeployStatusEvent::TYPE_BUILDING, $task->id, $task->version));

        try {
            if (empty($task->scriptBuild)) {
                throw new EmptyAttributeException("No build script detected - can't build");
            }

            $outputBuildScript = $this->getScriptExecutor($task->scriptBuild, '/tmp/build-script-', [
                'projectName' => $task->project,
                'version' => $task->version,
                'projectDir' => $projectBuildDir,
                'release' => $task->release,
                'taskId' => $task->id,
            ])();

            if (!empty($task->scriptMigrationNew)) {
                Yii::info("No migration script detected - so no migrations");
                Yii::info("projectDir=$projectBuildDir");
                // an: Проект с миграциями
                $command = self::MIGRATION_COMMAND_NEW_ALL;
                foreach ([self::MIGRATION_TYPE_PRE, self::MIGRATION_TYPE_POST, self::MIGRATION_TYPE_HARD] as $type) {
                    $text = $this->getScriptExecutor($task->scriptMigrationNew, '/tmp/migration-new-script-', [
                        'project' => $task->project,
                        'version' => $task->version,
                        'type' => $type,
                        'command' => $command,
                    ])();

                    $lines = explode("\n", str_replace("\r", "", $text));
                    $migrations = array_filter($lines);
                    $migrations = array_map('trim', $migrations);

                    Event::trigger(self::class, self::EVENT_MIGRATION_FINISH, new MigrationFinishEvent($task->project, $task->version, $migrations, $type, $command));
                }
            }

            $outputCronScript = empty($task->scriptCron) ? "" : $this->getScriptExecutor($task->scriptCron, '/tmp/cron-script-', [
                'projectName' => $task->project,
                'version' => $task->version,
            ])();

            // We should always trigger config update event (empty $output is also config)
            Event::trigger(self::class, self::EVENT_CRON_CONFIG_UPDATE, new CronConfigUpdateEvent($task->id, $outputCronScript)); // <- output
            Event::trigger(self::class, self::EVENT_DEPLOY_STATUS, new DeployStatusEvent(DeployStatusEvent::TYPE_BUILT, $task->id, $task->version, $outputBuildScript));
        } finally {
            $task->accepted();
        }
    }

    /**
     * @param InstallTask $task
     *
     * @throws CommandExecutorException
     * @throws EmptyAttributeException
     * @throws FilesystemException
     * @throws ScriptExecutorException
     */
    public function deployInstall(InstallTask $task)
    {
        $projectBuildDir = $this->getProjectBuildDirPath($task->project, $task->version);

        Event::trigger(self::class, self::EVENT_DEPLOY_STATUS, new DeployStatusEvent(DeployStatusEvent::TYPE_INSTALLING, $task->id, $task->version));

        try {
            if (empty($task->scriptInstall)) {
                throw new EmptyAttributeException("Can't install project without installation script");
            }

            $output = $this->getScriptExecutor($task->scriptInstall, '/tmp/install-script-', [
                'projectName' => $task->project,
                'version' => $task->version,
                'projectDir' => $projectBuildDir,
                'servers' => implode(" ", $task->getProjectServers()),
            ])();

            Event::trigger(self::class, self::EVENT_DEPLOY_STATUS, new DeployStatusEvent(DeployStatusEvent::TYPE_INSTALLED, $task->id, $task->version, $output));

            $output = empty($task->scriptPostInstall) ? "" : $this->getScriptExecutor($task->scriptPostInstall, '/tmp/post-install-script-', [
                'projectName' => $task->project,
                'version' => $task->version,
                'projectDir' => $projectBuildDir,
            ])();

            Event::trigger(self::class, self::EVENT_DEPLOY_STATUS, new DeployStatusEvent(DeployStatusEvent::TYPE_POST_INSTALLED, $task->id, $task->version, $output));

        } finally {
            $task->accepted();
        }
    }

    /**
     * TODO: directory & file handling need refactoring, temporarily moved root directory to a method just for unit tests
     * @return string
     */
    public function getTmpDirectory(): string
    {
        return "/tmp";
    }

    /**
     * TODO: Replace with some kind of a directory manager instead of storing uniqid in object property
     * @param string|null $uniqid
     */
    protected function setProjectDirUniqid(string $uniqid = null)
    {
        $this->projectDirUniqid = $uniqid ?? uniqid();
    }

    /**
     * @param string $project
     *
     * @return string
     */
    public function getProjectDirectoryPath(string $project): string
    {
        return $this->getTmpDirectory() . "/config-local/{$project}-{$this->projectDirUniqid}/";
    }

    /**
     * @param string $project
     *
     * @return string
     */
    public function getTemporaryScriptPath(string $project): string
    {
        return $this->getTmpDirectory() . "/config-local-{$project}-" . uniqid() . ".sh";
    }

    /**
     * @param string $project
     * @param $filename
     *
     * @return string
     */
    public function getProjectFilenamePath(string $project, $filename): string
    {
        return $this->getProjectDirectoryPath($project) . $filename;
    }

    /**
     * @return CommandExecutor
     */
    public function getCommandExecutor(): CommandExecutor
    {
        return new CommandExecutor();
    }

    /**
     * @param string $script
     * @param string $scriptPathPrefix
     * @param array|null $env
     *
     * @return ScriptExecutor
     */
    public function getScriptExecutor(string $script, string $scriptPathPrefix, array $env = null): ScriptExecutor
    {
        return new ScriptExecutor($script, $scriptPathPrefix, $env);
    }

    /**
     * @param string $project
     * @param string $version
     *
     * @return string
     */
    public function getProjectBuildDirPath(string $project, string $version): string
    {
        return $this->projectBuildRoot . "/$project-$version";
    }
}
