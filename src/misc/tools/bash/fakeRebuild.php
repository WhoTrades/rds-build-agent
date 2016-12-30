<?php
$m = 1;

//$m = 0;
$version = $_SERVER['argv'][2];
echo "Version: '$version'\n";
sleep(rand($m, 2*$m));