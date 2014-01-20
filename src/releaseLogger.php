<?php
$app = $argv[1];
$version = $argv[2];
$action = $argv[3];

$url = 'http://api.whotrades.com/api/systems/*/rpc/json/releases';
$body = '{
   "method":"getPhpLogsSystem.getReleaseModel.saveAction",
   "params":[
      "' . $app . '",
      "' . $action . '",
      "' . $version . '"
   ],
   "jsonrpc":"2.0"
}';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,            $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,     $body );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/json'));

$result=curl_exec ($ch);
