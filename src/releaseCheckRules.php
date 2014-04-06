<?php
require('config.php');

list(, $app, $version, $action) = $argv;

$url = "http://$phplogsDomain/releaseReject/json/?app=".$app.'&action='.$action.'&version='.$version;
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$text=curl_exec ($ch);
$data = json_decode($text, true);
if (!$data['ok']) {
    foreach ($data['rejects'] as $reject) {
        echo "WARNING: {$reject['user']}: {$reject['comment']}\n";
    }
    exit(2);
}
