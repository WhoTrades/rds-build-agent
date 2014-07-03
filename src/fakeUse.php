<?php
list(,$project,$version, $worker) = $_SERVER['argv'];
file_put_contents("deploy/fakeStatus_{$worker}.php", "nye-ap3.whotrades.net: $project-$version
nye-ap4.whotrades.net: $project-$version");