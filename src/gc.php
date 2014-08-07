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

$commands = [];
foreach (array_chunk($toTest, 100) as $part) {
    $toDelete = RemoteModel::getInstance()->getProjectBuildsToDelete($part);

    foreach ($toDelete as $val) {
        $project = $val['project'];
        $version = $val['version'];
        if (strlen($project) < 3) continue;
        if (strlen($version) < 3) continue;
        $commands[] = "rm -rf /home/release/buildroot/$project-$version";
        $commands[] = "bash deploy/deploy.sh remove $project $version";
        $commands[] = "reprepro -b /var/www/whotrades_repo/ remove wheezy $project-$version";
    }
}
echo "Commands: \n";
echo implode("\n", $commands);
