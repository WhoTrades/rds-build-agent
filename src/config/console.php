<?php
use \yii\console\ErrorHandler;
use whotrades\RdsBuildAgent\lib\PsrTarget;
use \whotrades\RdsBuildAgent\services\DeployService;
use \Psr\Log\LoggerInterface;
use \whotrades\MonologExtensions\LoggerWt;
use \whotrades\MonologExtensions\Processor;
use \whotrades\MonologExtensions\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use \Monolog\Processor\PsrLogMessageProcessor;


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
                ]
            ],
        ],
        'errorHandler' => array(
            'class' => ErrorHandler::class,
            'discardExistingOutput' => false,
        ),
    ],
    'container' => [
        'singletons' => [
            DeployService::class => [
                'class' => DeployService::class,
            ],
            LoggerInterface::class => function () {
                $logger = new LoggerWt('main');
                $logger->pushProcessor(new Processor\TagCollectorProcessor());
                $logger->pushProcessor(new Processor\TagProcessProcessor());
                $logger->pushProcessor(new Processor\LoggerNameProcessor());
                $logger->pushProcessor(new Processor\OperationProcessor());

                $streamHandler = new StreamHandler("php://stdout", \Monolog\Logger::INFO);
                $streamHandler->pushProcessor(new PsrLogMessageProcessor());
                $streamHandler->setFormatter(new LineFormatter(null, ''));
                $logger->pushHandler($streamHandler);

                return $logger;
            },
        ],
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
