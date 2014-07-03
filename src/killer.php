<?php
require('config.php');
require('functions.php');

echo "Starting work ".date("Y-m-d H:i:s")."\n";
$f = fopen("deploy/".Config::$workerName.".kill.php.lock", "w");
$wouldblock = 0;
$t = flock($f, LOCK_EX | LOCK_NB, $wouldblock);
if(!$t && $wouldblock) {
    die("Script already working\n");
}

for (;;) {
    $data = RemoteModel::getInstance()->getKillTask(\Config::$workerName);
    if (!$data) {
        sleep(5);
        continue;
    }

    $project = $data['project'];
    $taskId = $data['id'];

    echo date("r").": Killing $project, task_id=$taskId\n";

    try {
        $filename = __DIR__."/".Config::$workerName."_deploy.php.pgid";
        if (!file_exists($filename)) {
            return;
        }
        $pid = file_get_contents($filename);
        echo date("r")." Pid: $pid at filename $filename\n";
        exec("kill -- -$pid");
        sleep(1);

    } catch (CommandException $e) {
        RemoteModel::getInstance()->setUseError($taskId, $e->getMessage()."\nOutput: ".$e->output);
        echo date("r").": ".$e->getMessage()."\n";
    }
}
