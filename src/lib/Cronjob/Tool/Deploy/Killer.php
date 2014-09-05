<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Killer -vv
 */
class Cronjob_Tool_Deploy_Killer extends Cronjob\Tool\ToolBase
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
        $data = RemoteModel::getInstance()->getKillTask($workerName);
        if (!$data) {
            $this->debugLogger->message("No process to kill");
            return;
        }

        $project = $data['project'];
        $taskId = $data['id'];

        $this->debugLogger->message("Killing $project, task_id=$taskId");

        try {
            $filename = \Config::getInstance()->pid_dir."/{$workerName}_deploy.php.pgid";
            if (!file_exists($filename)) {
                $this->debugLogger->message("No pid file $filename, may be process already finished");
                return;
            }
            $pid = file_get_contents($filename);
            $this->debugLogger->message("Pid: $pid at filename $filename");
            exec("kill -- -$pid");
        } catch (CommandExecutorException $e) {
            RemoteModel::getInstance()->setUseError($taskId, $e->getMessage()."\nOutput: ".$e->output);
            $this->debugLogger->error("CMD error: ".$e->getMessage());
        }
    }
}
