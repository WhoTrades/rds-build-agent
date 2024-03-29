<?php
use \yii\console\ErrorHandler;
use whotrades\RdsBuildAgent\lib\PsrTarget;
use \whotrades\RdsBuildAgent\services\DeployService;
use \Psr\Log\LoggerInterface;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Processor\PsrLogMessageProcessor;
use \Monolog\Processor\ProcessorInterface;
use \Monolog\Handler\HandlerInterface;
use \whotrades\RdsBuildAgent\lib\PosixGroupManager;
use whotrades\RdsSystem\Migration\LoggerInterface as MigrationLoggerInterface;
use whotrades\RdsBuildAgent\lib\MigrationLoggerFiltersInContext;

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
                    'logVars' => [],
                    'exportInterval' => 1,
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
            DeployService::class => function () {
                return new DeployService(Yii::$app->params['buildDir'], []);
            },
            LoggerInterface::class => function () {
                $loggerConfig = Yii::$app->params['logger'];
                $processors = $loggerConfig['processors'] ?: [];
                $handlers = $loggerConfig['handlers'] ?: [];

                $logger = new Logger('main');

                foreach ($processors as $processor) {
                    if ($processor instanceof ProcessorInterface) {
                        $logger->pushProcessor($processor);
                    }
                }

                foreach ($handlers as $handler) {
                    if (is_callable($handler)) {
                        $handler = call_user_func($handler);
                    }
                    if ($handler instanceof HandlerInterface) {
                        $logger->pushHandler($handler);
                    }
                }

                return $logger;
            },
            PosixGroupManager::class => [
                'class' => PosixGroupManager::class,
            ],
        ],
        'definitions' => [
            MigrationLoggerInterface::class => MigrationLoggerFiltersInContext::class,
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
        'logger' => [
            'processors' => [
                new PsrLogMessageProcessor(),
            ],
            'handlers' => [
                new StreamHandler("php://stdout", \Monolog\Logger::INFO),
            ],
        ],
    ],
];

return $config;
