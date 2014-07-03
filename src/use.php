<?php
require('config.php');
require('functions.php');

echo "Starting work ".date("Y-m-d H:i:s")."\n";
$f = fopen("deploy/".Config::$workerName.".use.php.lock", "w");
$wouldblock = 0;
$t = flock($f, LOCK_EX | LOCK_NB, $wouldblock);
if(!$t && $wouldblock) {
    die("Script already working\n");
}

for (;;) {
        sleep(1);
        $data = RemoteModel::getInstance()->getUseTask(\Config::$workerName);
        if (!$data) {
            continue;
        }

        $project = $data['project'];
        $taskId = $data['id'];
        $version = $data['version'];
        $useStatus = $data['use_status'];

        echo date("r").": Using $project:$version, task_id=$taskId\n";

    try {
        $command = "deploy/deploy.sh status $project 2>&1";

        if (Config::$debug) {
            $command = "php deploy/fakeStatus_".Config::$workerName.".php";
        }
        $text = executeCommand($command);
        echo $text."\n";

        $oldVersion = null;
        foreach (array_filter(explode("\n", str_replace("\r", "", $text))) as $line) {
            if (false === strpos($line, ' ')) {
                RemoteModel::getInstance()->setUseError($taskId, "Invalid output of status script:\n" . $text);
                continue 2;
            }
            list($server, $sv) = explode(" ", $line);
            if ($oldVersion === null) {
                $oldVersion = $sv;
            } elseif ($oldVersion != $sv) {
                RemoteModel::getInstance()->setUseError($taskId, "Versions of project different on servers:\n".$text);
                continue 2;
            }
        }

        $oldVersion = str_replace("$project-", "", $oldVersion);
        $oldVersion = preg_replace("~\-1$~", "", $oldVersion);

        $reply = RemoteModel::getInstance()->setOldVersion($taskId, $oldVersion);
        if (!$reply['ok']) {
            echo date("r").": Can't send old version of $project to server\n";
            continue;
        }

        $command = "deploy/deploy.sh use $project $version 2>&1";
        if (Config::$debug) {
            $command = "php deploy/fakeUse.php $project $version ".Config::$workerName;
        }
        $text = executeCommand($command);

        if (Config::$debug) {
            $command = "php deploy/fakeStatus_".Config::$workerName.".php";
        }

        try {
            RemoteModel::getInstance()->setUsedVersion(\Config::$workerName, $project, $version, $useStatus);
        } catch (\Exception $e) {
            echo "Can't send to server real used version, reverting...\n";
            $command = "deploy/deploy.sh use $project $oldVersion 2>&1";
            if (Config::$debug) {
                $command = "php deploy/fakeUse.php $project $version ".Config::$workerName;
            }
            $text = executeCommand($command);
            RemoteModel::getInstance()->setUsedVersion(\Config::$workerName, $project, $oldVersion, 'used');
        }

        if ($useStatus == 'used_attempt') {
            sleep(15);

            $reply = RemoteModel::getInstance()->getCurrentStatus($taskId);
            if ($reply['status'] != 'used') {
                echo date("r").": Reverting $project back to v.$oldVersion, task_id=$taskId\n";
                $command = "deploy/deploy.sh use $project $oldVersion 2>&1";
                if (Config::$debug) {
                    $command = "php deploy/fakeUse.php $project $oldVersion ".Config::$workerName;
                }
                $text = executeCommand($command);
                RemoteModel::getInstance()->setUsedVersion(\Config::$workerName, $project, $oldVersion, 'used');
            } else {
                echo date("r").": Project $project v.$version marked as stable, skip reverting, task_id=$taskId\n";
            }
        }

    } catch (CommandException $e) {
        RemoteModel::getInstance()->setUseError($taskId, $e->getMessage()."\nOutput: ".$e->output);
        echo date("r").": ".$e->getMessage()."\n";
    }
}
