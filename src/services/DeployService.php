<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services;

use samdark\log\PsrMessage;
use whotrades\RdsSystem\lib\CommandExecutor;
use whotrades\RdsSystem\lib\Exception\CommandExecutorException;
use whotrades\RdsSystem\lib\Exception\EmptyAttributeException;
use whotrades\RdsSystem\lib\Exception\FilesystemException;
use whotrades\RdsSystem\Message\ProjectConfig;
use whotrades\RdsSystem\Message\UseTask;
use yii\base\BaseObject;

class DeployService extends BaseObject
{
    /** @var PosixGroupManager */
    private $posixGroupManager;

    /** @var string */
    private $projectDirectoryUniqid;

    public function __construct(PosixGroupManager $posixGroupManager, $config = null)
    {
        $config = $config ?? [];
        $this->posixGroupManager = $posixGroupManager;
        $this->setProjectDirectoryUniqid();
        parent::__construct($config);
    }

    /**
     * @param UseTask $task
     *
     * @return string
     *
     * @throws EmptyAttributeException
     * @throws FilesystemException
     * @throws CommandExecutorException
     */
    public function useProjectVersion(UseTask $task): string
    {
        $project = $task->project;
        $releaseRequestId = (int) $task->releaseRequestId;
        $version = $task->version;

        $commandExecutor = $this->getCommandExecutor();
        \Yii::info("Using $project:$version, task_id=$releaseRequestId");

        try {
            if (empty($task->scriptUse)) {
                \Yii::error(new PsrMessage("error_use_script_empty", [
                    'projectName' => $project,
                    'version' => $version,
                ]));
                $task->accepted();
                throw new EmptyAttributeException();
            }
            $env = [
                'projectName' => $project,
                'version' => $version,
                'servers' => implode(" ", $task->projectServers),
            ];

            $useScriptFilename = $this->getUseScriptPath();
            if (false === file_put_contents($useScriptFilename, str_replace("\r", "", $task->scriptUse))) {
                $errorMessage = "Can't save shell script";
                \Yii::error(new PsrMessage($errorMessage, [
                    'project' => $project,
                    'filename' => $useScriptFilename,
                    'content' => $task->scriptUploadConfigLocal,
                ]));
                $task->accepted();
                throw new FilesystemException($errorMessage, FilesystemException::ERROR_WRITE_FILE);
            }
            chmod($useScriptFilename, 0777);

            $command = "$useScriptFilename 2>&1";
            $text = $commandExecutor->executeCommand($command, $env);

            \Yii::info("Use command output: $text");
            unlink($useScriptFilename);
            \Yii::info("Used version: $version");

            $task->accepted();

            \Yii::info("Successful used $project-$version");
            return $text; // ???
        } catch (CommandExecutorException $e) {
            $output = $e->getMessage() . "\nOutput: " . $e->output;
            \Yii::error(new PsrMessage("error_synchronization_config_local_skip_message", [
                'command' => $e->getCommand(),
                'output' => $e->getOutput(),
                'projectName' => $project,
                'version' => $version,
            ]));

            $task->accepted();
            throw new CommandExecutorException($e->getCommand(), $output, $e->getCode(), $e->getOutput(), $e);
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
        $this->setProjectDirectoryUniqid(); //mr: new uniqid for each run
        \Yii::info("Task received: " . json_encode($task));
        $project = $task->project;

        if (empty($task->scriptUploadConfigLocal)) {
            \Yii::warning("Skip task, as scriptUploadConfigLocal is empty");
            $task->accepted();
            throw new EmptyAttributeException();
        }

        $projectDir = $this->getProjectDirectoryPath($task->project);
        if (!is_dir($projectDir)) {
            if (!mkdir($projectDir, 0777, true)) {
                $errMessage = "Can't create tmp dir";
                \Yii::error(new PsrMessage($errMessage, [
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
                \Yii::error(new PsrMessage($errMessage, [
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
            \Yii::error(new PsrMessage($errMessage, [
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
            \Yii::debug("Output: " . $output);

            foreach (glob("$projectDir/*") as $file) {
                unlink($file);
            }
            rmdir($projectDir);
            unlink($tmpScriptFilename);

            \Yii::info("Sync success");
            $task->accepted();
        } catch (CommandExecutorException $e) {
            $output = $e->getMessage() . "\nOutput: " . $e->output;
            \Yii::error(new PsrMessage("error_synchronization_config_local_skip_message", [
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

    public function deployBuild(BuildTask $task, string $workerName)
    {
        $this->posixGroupManager->setCurrentPidAsGid(); // mr: TODO: move to createPidFile maybe?
        $this->createPidFile($workerName, $task->id);
        $projectBuildDir = $this->getProjectBuildDirPath($task->project, $task->version);
        // an: Сигнализируем о начале работы
        // TODO: produce event
        //$this->sendStatus('building');

        $currentOperation = self::CURRENT_OPERATION_BUILDING;
        //$text = $this->processBuildProject($projectBuildDir, $task->scriptBuild, $task->project, $task->version, $task->release, $task->id);
        if (empty($task->scriptBuild)) {
            throw new \Exception("No build script detected - can't build");
        }

        $text = $this->processScript(
            $task->scriptBuild,
            '/tmp/build-script-',
            [
                'projectName' => $task->project,
                'version' => $task->version,
                'projectDir' => $projectBuildDir,
                'release' => $task->release,
                'taskId' => $task->id,
            ]
        );

        $currentOperation = self::CURRENT_OPERATION_GET_MIGRATIONS_LIST;
        //$this->processMigrations($projectBuildDir, $task->scriptMigrationNew, $task->project, $task->version);
        if (!empty($task->scriptMigrationNew)) {
            Yii::info("No migration script detected - so no migrations");
            Yii::info("projectDir=$projectBuildDir");
            // an: Проект с миграциями
            $command = self::MIGRATION_COMMAND_NEW_ALL;
            foreach ([self::MIGRATION_TYPE_PRE, self::MIGRATION_TYPE_POST, self::MIGRATION_TYPE_HARD] as $type) {
                $text = $this->processScript(
                    $task->scriptMigrationNew,
                    '/tmp/migration-new-script-',
                    [
                        'project' => $task->project,
                        'version' => $task->version,
                        'type' => $type,
                        'command' => $command,
                    ]
                );

                Yii::trace("Output: $text");
                $lines = explode("\n", str_replace("\r", "", $text));
                $migrations = array_filter($lines);
                $migrations = array_map('trim', $migrations);
                $this->model->sendMigrations(
                    new Message\ReleaseRequestMigrations($task->project, $task->version, $migrations, $type, $command)
                );
            }
        }



        // an: Отправляем новые сгенерированные cron.d конфиги
        $currentOperation = self::CURRENT_OPERATION_GEN_CRON_CONFIGS;
        $cronConfig = $this->processGenCronConfis($task->scriptCron, $task->project, $task->version);

        // TODO: produce event
        /*$this->model->sendCronConfig(
            new Message\ReleaseRequestCronConfig($task->id, $cronConfig)
        );*/

        // an: Сигнализируем что все сделали
        // TODO: produce event
        //$this->sendStatus('built', $version, $text);
        $this->posixGroupManager->restoreGid();
    }

    public function installTask(InstallTask $task)
    {

    }

    /**
     * TODO: directory & file handling need refactoring, temporarily moved root directory to a method just for unit tests
     * @return string
     */
    public function getTmpDirectory(): string
    {
        return "/tmp";
    }

    protected function setProjectDirectoryUniqid(string $uniqid = null)
    {
        $this->projectDirectoryUniqid = $uniqid ?? uniqid();
    }

    /**
     * @param string $project
     *
     * @return string
     */
    public function getProjectDirectoryPath(string $project): string
    {
        return $this->getTmpDirectory() . "/config-local/{$project}-{$this->projectDirectoryUniqid}/";
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
     * @return string
     */
    public function getUseScriptPath(): string
    {
        return $this->getTmpDirectory() . "/deploy-use-" . uniqid() . ".sh";
    }

    /**
     * @return CommandExecutor
     */
    public function getCommandExecutor(): CommandExecutor
    {
        return new CommandExecutor();
    }
}
