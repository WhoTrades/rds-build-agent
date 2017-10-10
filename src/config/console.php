<?php
use whotrades\RdsSystem\lib\ConsoleErrorHandler;

$config = [
    'id' => 'service-deploy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'sentry'],
    'controllerNamespace' => 'whotrades\RdsBuildAgent\commands',
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
            'class' => mito\sentry\Component::class,
            'dsn' => '<<<your-sentry-dsn>>>', // private DSN
        ],
        'errorHandler' => array(
            'class' => ConsoleErrorHandler::class,
            'discardExistingOutput' => false,
        ),
    ],
    'params' => [
        'debug' => false,
        'pidDir' => '/tmp/rds-build-agent/pid/',
        'buildDir' => '/tmp/rds-build-agent/builds/',
        'tmpDir' => '/tmp/rds-build-agent/tmp/',
    ],
];

return $config;
