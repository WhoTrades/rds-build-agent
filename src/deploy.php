<?php
require('config.php');
$url = "http://$phplogsDomain/releaseReject/json/?app=comon";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

$text=curl_exec ($ch);
$data = json_decode($text, true);
$commands = array();
$version = date('Y.m.d.H.i');
foreach ($data['requests'] as $request) {
	foreach ($request['projects'] as $project => $tmp) {
		$cmd = "bash deploy/deploy.sh install $project $version";
		$commands[] = $cmd;
	}
}
$commands = array_unique($commands);
foreach ($commands as $command) {
	echo "Executing `$command`\n";
	echo exec($command);
}

