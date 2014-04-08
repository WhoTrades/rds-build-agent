<?php
require('config.php');

list(, $app, $deleteTo) = $argv;

$url = "http://$phplogsDomain/releases/json/?app=$app&deleteTo=$deleteTo";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$result=curl_exec ($ch);
