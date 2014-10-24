<?php
use RdsSystem\Message;

/**
 * Слушает по сокету прогресс выполнения миграции, и транслирует эти данные в RDS
 *
 * @author Artem Naumenko
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_HardMigrationProxy -vv
 */
class Cronjob_Tool_Deploy_HardMigrationProxy extends RdsSystem\Cron\RabbitDaemon
{
    const LISTEN_PORT = 54321;
    const LISTEN_HOST = '0.0.0.0';

    public static function getCommandLineSpec()
    {
        return [] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model  = $this->getMessagingModel($cronJob);

        $sock = socket_create_listen(self::LISTEN_PORT);
        socket_getsockname($sock, $addr, $port);
        $this->debugLogger->message("Server Listening on $addr:$port");

        while($c = socket_accept($sock)) {
            /* do something useful */
            socket_getpeername($c, $raddr, $rport);
            $this->debugLogger->message("Received Connection from $raddr:$rport");

            if (!$bytes = socket_recv($c, $text, 1024, MSG_WAITALL)) {
                if (socket_last_error()) {
                    $this->debugLogger->error(socket_strerror(socket_last_error()));
                }
                continue;
            }

            $messages = array_filter(explode("\n", $text));
            foreach ($messages as $message) {
                $this->debugLogger->message("Received message: $message, resending it to RDS");
                $migration = json_decode($message);
                $model->sendHardMigrationProgress(new Message\HardMigrationProgress($migration->migration, $migration->progress, $migration->action, $migration->pid));
            }

            $cronJob->checkStillCanRun();
        }
        socket_close($sock);
    }
}
