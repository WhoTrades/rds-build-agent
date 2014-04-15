<?php
require('config.php');

list(, $app, $deleteTo, $status) = $argv;

$url = "http://$phplogsDomain/releaseReject/json/?app=$app&deleteTo=$deleteTo&status=$status";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$result=curl_exec ($ch);
