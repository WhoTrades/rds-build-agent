<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_ResendBuildPatch -vv
 */

use RdsSystem\Message;
use RdsSystem\lib\CommandExecutor;
use RdsSystem\lib\CommandExecutorException;

class Cronjob_Tool_Deploy_ResendBuildPatch extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [
            'project' => [
                'desc' => 'Project to resend version',
                'required' => true,
                'valueRequired' => true,
            ],
            'version' => [
                'desc' => 'Version of build of project',
                'required' => true,
                'valueRequired' => true,
            ],
            'lastBuildTag' => [
                'desc' => 'Previous build tag of this project',
                'required' => true,
                'valueRequired' => true,
            ],
            'dry-run' => [
                'desc' => 'Dry run or not',
            ],
        ] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model  = $this->getMessagingModel($cronJob);
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $project = $cronJob->getOption('project');
        $version = $cronJob->getOption('version');
        $lastBuildTag = $cronJob->getOption('lastBuildTag');


        //an: Сигнализируем о начале работы
        $srcDir="/home/release/build/$project";

        if ($lastBuildTag) {
            $command = "(cd $srcDir/lib; node /home/release/git-tools/alias/git-all.js \"git log $lastBuildTag..$project-$version --pretty='%H|%s|/%an/'\")";
        } else {
            $command = "(cd $srcDir/lib; node /home/release/git-tools/alias/git-all.js \"git log $lastBuildTag --pretty='%H|%s|/%an/'\")";
        }

        if (Config::getInstance()->debug) {
            $command = "cat /home/an/log.txt";
        }

        try {
            $output = $commandExecutor->executeCommand($command);
        } catch (CommandExecutorException $e) {
            //an: 128 - это когда нет какого-то тега в прошлом.
            //@todo подумать как это корректо обрабатывать такую ситуацию и реализовать
            if ($e->getCode() != 128) {
                throw $e;
            } else {
                $output = $e->output;
            }
        }

        $this->debugLogger->message("Sending building patch, length=".strlen($output));

        if ($cronJob->getOption('dry-run')) {
            $this->debugLogger->message("Output: $output");
        } else {
            $model->sendBuildPatch(
                new Message\ReleaseRequestBuildPatch($project, $version, $output)
            );
        }
    }
}
