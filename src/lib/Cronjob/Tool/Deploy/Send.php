<?php
use RdsSystem\Message;

/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Send -vv
 */
class Cronjob_Tool_Deploy_Send extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or  $this->debugLogger->message(socket_strerror(socket_last_error()));
        socket_connect($sock, '0.0.0.0', 39319);
        for ($i =0; $i < 10; $i++) {
            $message = time()."\n";

            socket_write($sock, $message, strlen($message)) or $this->debugLogger->message(socket_strerror(socket_last_error($sock)));

        }

        socket_close($sock) or $this->debugLogger->message(socket_strerror(socket_last_error($sock)));
        return;


        $project = 'rds';
        $filename = "/home/an/dev/services/rds/misc/tools/migration.php";

        $command = "php $filename --type=hard --project=$project --restart up 1 --progress=127.0.0.1:55678";
    }
}
