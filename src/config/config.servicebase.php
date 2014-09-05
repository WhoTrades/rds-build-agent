<?php
// is debug mode active? instance of site for tests (1), or it is production webserver (0)
$this->DEBUG_MODE = 0;
$this->JSON_DEBUG_MODE = 0;
$this->debug_php53 = 0;  // option to ignore deprecated notices in debug mode
// vdm: Is debug asserts enabled in debug mode?
$this->DEBUG_ASSERT = 1;

$this->debug_php53 = 0;

// vdm: Do collect stat info (0 - no; 1 - file; 2 - memcache)?
$this->stat_mode = 2;

// values for PHP's setlocale()
$this->locale = "en_UK.UTF8";
$this->locale_numeric = "C";
$this->locale_numeric_output = "en_UK.UTF8";
$this->locale_messages = "C";

// default timezone (database must understand it)
$this->timezone_default = "America/New_York";

// User-Agent header for opening all files via http
$this->php_user_agent = "whotrades.com; http://whotrades.com; info@whotrades.eu";

$this->fatalControllerLocation = null;

//$this->mailerMongoDb = 'mongodb://mgdb-0-1.comon_maildb.local:27017,mgdb-0-2.comon_maildb.local:27017';
$this->mailerMongoDb = array(
    'dsn'=>'mongodb://mgdb-0-1.comon_maildb.local:27017,mgdb-0-2.comon_maildb.local:27017',
    //'dsn'=>'mongodb://mgdb-0-1.comon_maildb.local:27010,mgdb-0-2.comon_maildb.local:27010', //for unavalibality check
    'db'=>'comon_maildb'
);

// vdm: api location of service phplogs
$this->phpLogsSystem['service']['location'] = 'http://phplogs.whotrades.net/api/';
$this->phpLogsSystem['service']['timeout'] = 5;
// ad: moved from config.comon.php

$this->phpLogsSystem['location'] = '/var/log/phplogs/';
$this->phpLogsSystem['timezones']['source'] = "America/New_York";
$this->phpLogsSystem['timezones']['default'] = "Europe/Moscow";
$this->phpLogsSystem['notification'] = array(
    'releaseRequested' => 'release-please@whotrades.org',
    'releaseRejected' => 'release-impossible@whotrades.org',
    'releaseReleased' => 'release-released@whotrades.org',
    'buildStatus' => 'release-build-status@whotrades.org',
);
$this->phpLogsSystem['udp'] = array(
    'enabled'   => 1,
    'hosts'     => array(
        'udp2http-1.local:17866',
        'udp2http-1.local:17867',
    ),
    'packageSize' => 1000,       //bytes
);


$this->phpLogsSystem['crm_link'] = array(
    'trader' => "http://crm.whotrades.com/people/trader/",
    'person' => "http://crm.whotrades.com/people/"
);

$this->phpLogsSystem['notify']['emails'] = array('sos+phplogs@whotrades.org');

// bn: settings for grabbing detailed logs for performance and operations monitoring and analytics
$this->monitoring['daemon']['enabled'] = false;
$this->monitoring['storage']['enabled'] = false;
$this->monitoring['storage']['connection'] = null;
$this->monitoring['daemon']['host'] = null;
$this->monitoring['daemon']['port'] = null;
$this->monitoring['storage']['db'] = null;


$this->monitoring['strategies'] = array();
$this->monitoring['business_loggers'] = array();


// bn: настройки для слива логов в грейлог, настройки транспорта, можно указать несколько транспортов, сообщения будут рассылаться всем
$this->grayLogSystem['errors'] = array(
    'enabled' => false,
    'transport' => array(
        array(
            'type' => 'udp',
            'host' => 'grlog-0-1.comon.local',
            'port' => 12201,
//          'enabled' => false
        )
    )
);

// sl: грейлог для бизнес метрики
$this->grayLogSystem['business'] = array(
    'enabled' => true,
    'transport' => array(
        array(
            'type' => 'udp',
            'host' => 'grlog-0-1.comon.local',
            'port' => 12202,
        )
    )
);

// bn: включаем слив логов в grayLog паралельно с отправкой в phpLogs @see lib\libcore\RequestHandler\Core::createDumpStorage
$this->phpLogsSystem['useGrayLogSystem'] = true;