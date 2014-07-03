<?php
require('config.php');
require('functions.php');

echo "Starting work ".date("Y-m-d H:i:s")."\n";
$f = fopen(__DIR__."/".Config::$workerName."_migration.php.lock", "w+");
$wouldblock = 0;
$t = flock($f, LOCK_EX | LOCK_NB, $wouldblock);
if(!$t && $wouldblock) {
    die("Script already working\n");
}

for (;;) {
    sleep(5);

    $data = RemoteModel::getInstance()->getMigrationTask(\Config::$workerName);

    if ($data) {
        $project = $data['project'];
        $version = $data['version'];
    } else {
        echo ("No work\n");
        continue;
    }

    try {
        //an: Должно быть такое же, как в rebuild-package.sh
        $filename = "/home/release/buildroot/$project-$version/var/pkg/$project-$version/misc/tools/migration.php";
        $command = "php $filename migration --type=pre --project=$project up --interactive=0";
        $count = executeCommand($command);
        RemoteModel::getInstance()->sendMigrationStatus($project, $version, 'up');
    } catch (CommandException $e) {
        $text = $e->output;
        RemoteModel::getInstance()->sendMigrationStatus($project, $version, 'failed');
        exit($e->getCode());
    } catch (Exception $e) {
        RemoteModel::getInstance()->sendMigrationStatus($project, $version, 'failed');
    }
}
