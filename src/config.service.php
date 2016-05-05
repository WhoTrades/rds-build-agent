<?php
$this->rdsDomain = "rds.whotrades.net";
$this->workerName = 'debian';
$this->debug = false;
$this->createTag = 0;
$this->environment = 'prod';
$this->mergePoolDir = '/home/release/mergePool/';
$this->mergeDryRun = false;

//an: Используется для фильтрации прод серверов от пре-прод серверов
$this->serverRegex = '~.*~';

$this->installToPreprod = true;

$this->hardMigration = [
    'autoStartEnvironments' => ['preprod'],
];

// an: хак, пока не выпилим phplogs изо-всех сервисов
unset($this->phpLogsSystem);
