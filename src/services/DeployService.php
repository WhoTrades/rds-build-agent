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
                \Yii::error(new PsrMessage("cant_save_use_shell_script", [
                    'project' => $project,
                    'filename' => $useScriptFilename,
                    'content' => $task->scriptUploadConfigLocal,
                ]));
                $task->accepted();
                throw new FilesystemException("Can't save shell script", FilesystemException::ERROR_WRITE_FILE);
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
                \Yii::error(new PsrMessage("cant_create_tmp_dir", [
                    'project' => $project,
                    'projectDir' => $projectDir,
                ]));
                $task->accepted();
                throw new FilesystemException("Can't create tmp dir", FilesystemException::ERROR_WRITE_DIRECTORY);
            }
        }

        foreach ($task->configs as $filename => $content) {
            $filePath = $this->getProjectFilenamePath($task->project, $filename);
            if (false === file_put_contents($filePath, $content)) {
                \Yii::error(new PsrMessage("cant_save_project_config", [
                    'project' => $project,
                    'filename' => $filePath,
                    'content' => $content,
                ]));
                $task->accepted();
                throw new FilesystemException("Can't save project config", FilesystemException::ERROR_WRITE_FILE);
            }
        }

        $tmpScriptFilename = $this->getTemporaryScriptPath($task->project);
        if (false === file_put_contents($tmpScriptFilename, str_replace("\r\n", "\n", $task->scriptUploadConfigLocal))) {
            \Yii::error(new PsrMessage("cant_save_tmp_shell_script", [
                'project' => $project,
                'filename' => $tmpScriptFilename,
                'content' => $task->scriptUploadConfigLocal,
            ]));
            $task->accepted();
            throw new FilesystemException("Can't save tmp shell script", FilesystemException::ERROR_WRITE_FILE);
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

    /**
     * TODO: directory & file handling need refactoring, temporarily moved root directory to a method just for unit tests
     * @return string
     */
    public function getTmpDirectory(): string
    {
        return "/tmp";
    }

    /**
     * @param string $project
     *
     * @return string
     */
    public function getProjectDirectoryPath(string $project): string
    {
        return $this->getTmpDirectory() . "/config-local/{$project}-" . uniqid() . "/";
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
