<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Migration -vv
 */
class Cronjob_Tool_Deploy_Migration extends Cronjob\Tool\ToolBase
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return array();
    }


    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $workerName = \Config::getInstance()->workerName;
        $commandExecutor = new CommandExecutor($this->debugLogger);

        $data = RemoteModel::getInstance()->getMigrationTask($workerName);

        if ($data) {
            $project = $data['project'];
            $version = $data['version'];
            $type = isset($data['type']) ? $data['type'] : 'pre';
        } else {
            $this->debugLogger->message("No work\n");
            return;
        }

        try {
            //an: Должно быть такое же, как в rebuild-package.sh
            $filename = "/home/release/buildroot/$project-$version/var/pkg/$project-$version/misc/tools/migration.php";
            $command = "php $filename migration --type=$type --project=$project up --interactive=0";
            $commandExecutor->executeCommand($command);
            RemoteModel::getInstance()->sendMigrationStatus($project, $version, $type, 'up');
        } catch (CommandException $e) {
            $text = $e->output;
            RemoteModel::getInstance()->sendMigrationStatus($project, $version, $type, 'failed');
            return $e->getCode();
        } catch (Exception $e) {
            RemoteModel::getInstance()->sendMigrationStatus($project, $version, $type, 'failed');
        }
    }
}
