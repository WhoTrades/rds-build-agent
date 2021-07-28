<?php
/**
 * Wrapper for Yii logger which add migration information to context
 *
 * @author Anton Gorlanov <antonxacc@gmail.com>
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\lib;

use Yii;
use yii\log\Logger;
use samdark\log\PsrMessage;
use whotrades\RdsSystem\Migration\LoggerInterface;
use whotrades\RdsSystem\Migration\LogAggregatorUrlInterface;

class MigrationLoggerFiltersInContext implements LoggerInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $context = [];

    /**
     * {@inheritDoc}
     */
    public function __construct(string $migrationName, string $migrationType, string $migrationProject)
    {
        $this->logger = Yii::getLogger();

        // ag: Replace backspace '\' with safe character '_'
        $migrationName = str_replace('\\', '_', $migrationName);
        $this->context = [
            LogAggregatorUrlInterface::FILTER_MIGRATION_NAME => $migrationName,
            LogAggregatorUrlInterface::FILTER_MIGRATION_TYPE => $migrationType,
            LogAggregatorUrlInterface::FILTER_MIGRATION_PROJECT => $migrationProject,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function error(string $message)
    {
        $this->log($message, Logger::LEVEL_ERROR);
    }

    /**
     * {@inheritDoc}
     */
    public function warning(string $message)
    {
        $this->log($message, Logger::LEVEL_WARNING);
    }

    /**
     * {@inheritDoc}
     */
    public function info(string $message)
    {
        $this->log($message, Logger::LEVEL_INFO);
    }

    /**
     * @param string $message
     * @param int $level
     */
    private function log(string $message, int $level)
    {
        foreach (explode("\n", $message) as $logString) {
            $this->logger->log(new PsrMessage($logString, $this->context), $level);
        }
    }
}
