<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Test -vv
 */

use \RdsSystem\Message;

class Cronjob_Tool_Test extends \RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return array();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $version = "62.00.101.173";
        $project = "comon";
        $releaseRequestId = 280;
        $taskId = 345;
        $worker = 'debian';

        $model  = $this->getMessagingModel($cronJob);

        $model->sendTaskStatusChanged(new Message\TaskStatusChanged($taskId, 'preprod_use'));

        $rdsSystem = new RdsSystem\Factory($this->debugLogger);
        $preprodModel  = $rdsSystem->getMessagingRdsMsModel('preprod');

        $this->debugLogger->message("Sending use task to preprod: project=$project, version=$version");

        $preprodModel->sendUseTask($worker, new Message\UseTask($project, $releaseRequestId, $version, 'used'));

        $preprodModel->readUsedVersion(false, function(Message\ReleaseRequestUsedVersion $message) use ($project, $version, $worker, $preprodModel, $model, $taskId){
            if ($message->version != $version || $message->project != $project || $message->worker != $worker) {
                return;
            }

            $message->accepted();
            if ($message->status == 'used') {
                $model->sendTaskStatusChanged(new Message\TaskStatusChanged($taskId, 'preprod_migrations'));
                $preprodModel->sendMigrationTask(new Message\MigrationTask($project, $version, 'pre'));
            } else {
                throw new Exception("Failed to migrate ".json_encode($message));
            }
        });

        $preprodModel->readUseError(false, function(Message\ReleaseRequestUseError $message) use ($releaseRequestId, $preprodModel, $model, $taskId){
            if ($message->releaseRequestId != $releaseRequestId) {
                return;
            }

            $message->accepted();

            $model->sendTaskStatusChanged(new Message\TaskStatusChanged($taskId, 'preprod_failed'));
            $this->debugLogger->error("Failed to use version on preprod, ".json_decode($message));
            $preprodModel->stopReceivingMessages();
        });

        $preprodModel->readOldVersion(false, function(Message\ReleaseRequestOldVersion $message) use ($releaseRequestId, $preprodModel, $model, $taskId){
            if ($message->releaseRequestId != $releaseRequestId) {
                return;
            }

            //an: Просто вачитываем очередь, что бы вообщения не скапливались
            $message->accepted();
        });

        $preprodModel->readMigrationStatus(false, function(Message\ReleaseRequestMigrationStatus $message) use ($project, $version, $worker, $preprodModel){
            $message->accepted();
            if ($message->version == $version && $message->project == $project && $message->type == 'pre') {
                if ($message->status == 'up') {
                    $this->debugLogger->message("Migrations are up to date, exiting");
                    $preprodModel->stopReceivingMessages();
                } else {
                     throw new Exception("Failed to migrate ".json_encode($message));
                }
            }
        });


        $preprodModel->waitForMessages();
    }
}
