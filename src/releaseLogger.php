<?php
require('config.php');

list(, $app, $version, $action) = $argv;

$url = "http://".Config::$rdsDomain."/releases/json/?app=".$app.'&action='.$action.'&version='.$version;
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$result=curl_exec ($ch);
