<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Test -vv
 */

use RdsSystem\Message;

class Cronjob_Tool_Test extends RdsSystem\Cron\RabbitDaemon
{
    public static function getCommandLineSpec()
    {
        return [
            'server' => [
                'desc' => '',
                'useForBaseName' => true,
                'valueRequired' => true,
            ],
        ] + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        while (true)
        {
            $socket = stream_socket_server('udp://localhost:51411', $errno, $errstr);
            if (!$socket) {
                echo "$errstr ($errno)<br />\n";
            } else {
                // while there is connection, i'll receive it... if I didn't receive a message within $nbSecondsIdle seconds, the following function will stop.
                while ($conn = stream_socket_accept($socket,5)) {
                    $message= fread($conn, 1024);
                    echo 'I have received that : '.$message;
                    fputs ($conn, "OK\n");
                    fclose ($conn);
                }
                fclose($socket);
            }
        }
    }
}

