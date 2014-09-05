<?php
$this->instrumentsSystem['output_gray_precision'] = array(
    '1'=>0.05,
    '7'=>0.1,
    '30'=>0.1,
    '90'=>0.1,
    '180'=>0.15,
    '360'=>0.15,
);

$this->instrumentsSystem['trades_popularity_k'] = 0.02;

$this->instrumentsSystem['calendar']= array(
    'url' => 'http://msk-websoa1.office.finam.ru/api/calendarstats/v1/rest/calendar',
    'timeout'=>10,

    'lcids'=>array(
        /**
         * 'Язык в API' => 'Язык у нас'
         */
        //'ru'=>'ru',
        'en'=>'en'
    ),
);

$this->instrumentsSystem['news'] =array(
    'url' => 'http://msk-websoa1.office.finam.ru/api/finamrunews/v1/rest/RssNews',
    'timeout'=>60,
    'timediff' => -4 * 3600,
);


$this->instrumentsSystem['instrumentCostHistory'] = array(
    'url'     => 'http://ta.finam.ru/ta/ta',
    'timeout' => 5,
    'timediff' => 4 * 3600,
);

$this->instrumentsSystem['mongo'] = array(
    'dsn' => 'mongodb://mgdb-0-1.iss.local:27017',
    'db' => 'isdb',
);

$this->instrumentsSystem['mssql-rates'] = array(
    'host' => 'frc-webdb11.ltd.finam.eu',
    'user' => 'whotrades',
    'password' => 'njkmrjyt12345',
    'db' => 'FData',
);

