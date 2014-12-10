<?php
$this->rdsDomain = "rds.whotrades.net";
$this->workerName = 'debian';
$this->debug = false;
$this->createTag = 0;
$this->environment = 'main';
$this->mergePoolDir = '/home/release/mergePool/';

//an: Используется для фильтрации прод серверов от пре-прод серверов
$this->serverRegex = '~.*~';

$this->installToPreprod = true;

$this->hardMigration = [
    'autoStartEnvironments' => ['preprod'],
];
