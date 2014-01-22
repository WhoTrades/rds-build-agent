<?php
$app = $argv[1];
$version = $argv[2];
$action = $argv[3];

$url = 'http://phplogs.mk.whotrades.net/releases/json/?app='.$app.'&action='.$action.'&version='.$version;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,            $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$result=curl_exec ($ch);
