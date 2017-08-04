<?php
$config = [
    'id' => 'service-deploy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'commandInstanceMutex' => [
            'class' => 'yii\mutex\FileMutex',
            'mutexPath' => '/var/lib/cronjob/service-deploy',
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
            'dsn' => 'https://0e1f7a05e34544bd95a1ad42643bff95:edee09e6ecda434f9a896021d3a3459f@sentry.dev.whotrades.net/13', // private DSN
        ],
    ],
    'params' => [
        'debug' => true,
        'pid_dir' => '/var/tmp/deploy/pid/',
        'rdsDomain' => 'rds.dev.whotrades.net',
        'createTag' => false,
        'merge' => [
            'mergeDir' =>  '/tmp/mergePool2/',
            'repositoryUrl' => 'ssh://git@git.finam.ru:7999/wt/git-merge-test.git',
        ],
    ],
];

return $config;
