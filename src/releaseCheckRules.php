<?php
require('config.php');
require('functions.php');

list(, $app) = $argv;
$data = \RemoteModel::getInstance()->getRejectsForProject($app);
if ($data) {
    foreach ($data as $reject) {
        $time = date('Y-m-d H:i:s', strtotime($reject['created']));
        echo "WARNING: {$reject['user']} ($time): {$reject['comment']}\n";
    }
    exit(66);
}
