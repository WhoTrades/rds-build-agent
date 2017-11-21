<?php
use whotrades\RdsSystem\lib\ConsoleErrorHandler;

$config = [
    'id' => 'service-deploy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'sentry'],
    'controllerNamespace' => 'whotrades\RdsBuildAgent\commands',
    'aliases' => [
        '@whotrades/RdsBuildAgent' => 'src',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'commandInstanceMutex' => [
            'class' => 'yii\mutex\FileMutex',
            'mutexPath' => '/tmp/service-deploy',
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stdout',
                    'levels' => ['info', 'warning', 'error'],
                    'logVars' => [],
                    'exportInterval' => 1,
                ],
            ],
        ],
        'sentry' => [
            'enabled' => false,
            'class' => mito\sentry\Component::class,
            'dsn' => 'https://36096034f31943d5e183555b2de11221:431c23f004608d05993c8df0ef54e096@sentry.com/1', // private DSN
        ],
        'errorHandler' => array(
            'class' => ConsoleErrorHandler::class,
            'discardExistingOutput' => false,
        ),
    ],
    'params' => [
        'messaging' => [
            'host'  => 'localhost',
            'port'  => 5672,
            'user'  => 'rds',
            'pass'  => 'rds',
            'vhost' => '/',
        ],
        'debug' => false,
        'pidDir' => '/tmp/rds-build-agent/pid/',
        'buildDir' => '/tmp/rds-build-agent/builds/',
        'tmpDir' => '/tmp/rds-build-agent/tmp/',
    ],
];

return $config;
