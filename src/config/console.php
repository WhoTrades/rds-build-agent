<?php
use \yii\console\ErrorHandler;
use \samdark\log\PsrTarget;

$logger = new \whotrades\MonologExtensions\LoggerWt('main');
$logger->pushProcessor(new \whotrades\MonologExtensions\Processor\TagCollectorProcessor());
$logger->pushProcessor(new \whotrades\MonologExtensions\Processor\TagProcessProcessor());
$logger->pushProcessor(new \whotrades\MonologExtensions\Processor\LoggerNameProcessor());
$logger->pushProcessor(new \whotrades\MonologExtensions\Processor\OperationProcessor());

$streamHandler = new \Monolog\Handler\StreamHandler("php://stdout", \Monolog\Logger::INFO);
$streamHandler->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
$streamHandler->setFormatter(new \whotrades\MonologExtensions\Formatter\LineFormatter(null, ''));
$logger->pushHandler($streamHandler);
/*
$sentryOptions = [
    'dsn' => 'https://0e1f7a05e34544bd95a1ad42643bff95:edee09e6ecda434f9a896021d3a3459f@sentry-gw-int.dev.whotrades.net/13',
    'release' => 'test_version',
    'send_default_pii' => true,
    'default_integrations' => false,
    'integrations' => [
        new \Sentry\Integration\RequestIntegration(),
    ],
];
$sentryClientBuilder = \Sentry\ClientBuilder::create($sentryOptions);
$sentryClient = $sentryClientBuilder->getClient();
$sentryHub =\Sentry\SentrySdk::getCurrentHub();
$sentryHub->bindClient($sentryClient);
$sentryHandler = new \whotrades\MonologExtensions\Handler\SentryHandler($sentryHub, \Monolog\Logger::ERROR);
$sentryHandler->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
$logger->pushHandler($sentryHandler);
*/
$config = [
    'id' => 'service-deploy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', ],
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
                    'class' => PsrTarget::class,
                    'logger' => $logger,
                ]
            ],
        ],
        'errorHandler' => array(
            'class' => ErrorHandler::class,
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
