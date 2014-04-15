<?php
require('config.php');

list(, $app) = $argv;

$url = "http://$phplogsDomain/releaseReject/json/?app=".$app.'&action=&version=';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$text=curl_exec ($ch);
$data = json_decode($text, true);
if (!$data['ok']) {
    foreach ($data['rejects'] as $reject) {
        $time = date('Y-m-d H:i:s', strtotime($reject['created']));
        echo "WARNING: {$reject['user']} ($time): {$reject['comment']}\n";
    }
    exit(66);
}
