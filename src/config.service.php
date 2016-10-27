<?php
$this->rdsDomain = "rds.whotrades.net";
$this->driver = 'deb';
$this->debug = false;
$this->DEBUG_MODE = $this->debug;
$this->createTag = 0;
$this->environment = 'prod';
$this->mergePoolDir = '/home/release/mergePool/';
$this->mergeDryRun = false;

// an: Используется для фильтрации прод серверов от пре-прод серверов
$this->serverRegex = '~.*~';

$this->installToPreprod = true;

$this->hardMigration = [
    'autoStartEnvironments' => ['preprod'],
];

// Dir for lock files. Should be version-independent
$this->lock_dir = '/var/lib/cronjob';

// memcache settings
$this->memcached['servers'] = [
    "mc-0-1.comon.local:11211",
];

$this->sentry['projects']['deploy']['dsn'] = 'https://ee918495084742d19a902e3b8bbf1e4b:a44fbc68ceea4ec5a6cde7ed1d3ab7e2@sentry.whotrades.com/5';
$this->sentry = [
    // сейчас поддерживается только плоский массив default
    // @see \RequestHandler_Core::getSentryConfig
    'default' => [
        'curl_method' => 'async',
    ],
];
