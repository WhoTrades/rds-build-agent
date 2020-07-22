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
use \Monolog\Processor\ProcessorInterface;
use Monolog\Handler\HandlerInterface;

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
            LoggerInterface::class => function () use ($config) {
                $loggerConfig = Yii::$app->params['logger'];
                $processors = $loggerConfig['processors'] ?: [];
                $handlers = $loggerConfig['handlers'] ?: [];

                $logger = new LoggerWt('main');

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
                new Processor\TagCollectorProcessor(),
                new Processor\TagProcessProcessor(),
                new Processor\LoggerNameProcessor(),
                new Processor\OperationProcessor(),
            ],
            'handlers' => [
                ((new StreamHandler("php://stdout", \Monolog\Logger::INFO))
                    ->pushProcessor(new PsrLogMessageProcessor())
                    ->setFormatter(new LineFormatter(null, ''))),
            ],
        ],
    ],
];

return $config;
