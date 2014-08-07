<?php
require('config.php');
require('functions.php');

echo "Starting work ".date("Y-m-d H:i:s")."\n";
$f = fopen(__DIR__."/".Config::$workerName."_gc.php.lock", "w+");
$wouldblock = 0;
$t = flock($f, LOCK_EX | LOCK_NB, $wouldblock);
if(!$t && $wouldblock) {
    die("Script already working\n");
}

$projects = RemoteModel::getInstance()->getProjects();

$toTest = array();
foreach ($projects as $project) {
    $command = config::$debug ? "cat deploy/whotrades_repo.txt" : "reprepro -b /var/www/whotrades_repo/ listmatched wheezy '{$project['name']}-*'";
    $text = executeCommand($command);
    if (preg_match_all('~'.$project['name'].'-([\d.]+)~', $text, $ans)) {
        $versions = $ans[1];
        foreach ($versions as $version) {
            $toTest[$project['name']."-".$version] = array(
                'project' => $project['name'],
                'version' => $version,
            );
        }
    } else {
        echo "No builds of {$project['name']} found\n";
    }
}

$command = config::$debug ? "cat deploy/whotrades_builds.txt" : "find /home/release/buildroot/ -maxdepth 1 -type d";
$text = executeCommand($command);
if (preg_match_all('~([\w-]{5,})-([\d.]{5,})~', $text, $ans)) {
    $versions = $ans[2];
    foreach ($versions as $key => $version) {
        $project = $ans[1][$key];
        $toTest["$project-$version"] = array(
            'project' => $project,
            'version' => $version,
        );
    }
} else {
    echo "No builds at /home/release/buildroot/ found\n";
}

foreach (array_chunk($toTest, 100) as $part) {
    $toDelete = RemoteModel::getInstance()->getProjectBuildsToDelete($part);

    foreach ($toDelete as $val) {
        $project = $val['project'];
        $version = $val['version'];
        if (strlen($project) < 3) continue;
        if (strlen($version) < 3) continue;
        if (in_array('--dry-run', $argv)) {
            echo "Fake removing $project-$version\n";
        } else {
            echo "Removing $project-$version\n";
            if (is_dir("/home/release/buildroot/$project-$version")) {
                executeCommand("rm -rf /home/release/buildroot/$project-$version");
            }
            try {
                executeCommand("bash deploy/deploy.sh remove $project $version");
            } catch (CommandException $e) {
                if ($e->getCode() != 1) {
                    //an: Код 1 - допустим, его игнорируем, значит просто не на всех серверах была установлена эта сборка
                    throw new CommandException($e->getMessage(), $e->getCode(), $e->output, $e);
                }
            }
            executeCommand("reprepro -b /var/www/whotrades_repo/ remove wheezy $project-$version");
            RemoteModel::getInstance()->removeReleaseRequest($project, $version);
        }
    }
}
