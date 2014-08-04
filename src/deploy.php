<?php
declare(ticks = 1);

require('config.php');
require('functions.php');

echo "Starting work ".date("Y-m-d H:i:s")."\n";
$f = fopen(__DIR__."/".Config::$workerName."_deploy.php.lock", "w+");
$wouldblock = 0;
$t = flock($f, LOCK_EX | LOCK_NB, $wouldblock);
if(!$t && $wouldblock) {
	die("Script already working\n");
}
file_put_contents(__DIR__."/".Config::$workerName."_deploy.php.pid", posix_getpid());
file_put_contents(__DIR__."/".Config::$workerName."_deploy.php.pgid", posix_getpgid(posix_getpid()));

$data = RemoteModel::getInstance()->getNextTask(\Config::$workerName);

if ($data) {
    $project = $data['project'];
    $taskId = $data['id'];
    $version = $data['version'];
	$release = $data['release'];
} else {
    die("No work\n");
}

pcntl_signal(SIGTERM, function($signal) use ($taskId, $version){
    echo "Cancelling...\n";
    RemoteModel::getInstance()->sendStatus($taskId, 'cancelled', $version);
    echo "Cancelled...\n";
    exit($signal);
});


$text = '';
$currentOperation = "none";
try {
    //an: Сигнализируем о начале работы
    $currentOperation = "send status 'building'";
    RemoteModel::getInstance()->sendStatus($taskId, 'building');

    //an: Собираем проект
    $command = "env VERBOSE=y bash deploy/rebuild-package.sh $project $version $release 2>&1";

    if (Config::$debug) {
        $command = "php deploy/fakeRebuild.php $project $version";
    }

    $currentOperation = "building";
    $text = executeCommand($command);

    //an: Сигнализируем все что собрали и начинаем раскладывать по серверам
    RemoteModel::getInstance()->sendStatus($taskId, 'built', $version);

    //an: Должно быть такое же, как в rebuild-package.sh
    $filename = "/home/release/buildroot/$project-$version/var/pkg/$project-$version/misc/tools/migration.php";
    $migrations = array();
    if (file_exists($filename)) {
        //an: Проект с миграциями
        $command = "php $filename migration --type=pre --project=$project new --limit=100000 --interactive=0";
        $text = executeCommand($command);
        if (preg_match('~Found (\d+) new migration~', $text, $ans)) {
            //an: Текст, начиная с Found (\d+) new migration
            $subtext = substr($text, strpos($text, $ans[0]));
            $lines = explode("\n", str_replace("\r", "", $subtext));
            array_shift($lines);
            $migrations = array_slice($lines, 0, $ans[1]);
            $migrations = array_map('trim', $migrations);
        }
    }

    RemoteModel::getInstance()->sendMigrations($taskId, $migrations);

    $currentOperation = "installing";
    //an: Раскладываем собранный проект по серверам
    $command = "bash deploy/deploy.sh install $project $version 2>&1";

    if (Config::$debug) {
        $command = "php deploy/fakeRebuild.php $project $version";
    }
    $text = executeCommand($command);

    //an: Сигнализируем все что сделали
    RemoteModel::getInstance()->sendStatus($taskId, 'installed', $version, $text);
    $currentOperation = "send status 'installed'";
} catch (CommandException $e) {
    if ($e->getCode() == 66) {
        //an: Это генерит скрипт releaseCheckRules.php
        echo "Release rejected\n";
        RemoteModel::getInstance()->sendStatus($taskId, 'failed');
    } else {
        $text = $e->output;
        echo "\n=======================\n";
        $title = "Failed to execute '$currentOperation'";
        echo "$title\n";
        RemoteModel::getInstance()->sendStatus($taskId, 'failed', $version, $text);
    }
    exit($e->getCode());
} catch (Exception $e) {
    RemoteModel::getInstance()->sendStatus($taskId, 'failed', $version, $e->getMessage());
}
