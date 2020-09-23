<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

use yii\base\Event;

final class CronConfigUpdateEvent extends Event
{
    /** @var int */
    private $taskId;

    /** @var string  */
    private $cronConfig;

    public function __construct(int $taskId, string $cronConfig, $config = null)
    {
        $this->taskId = $taskId;
        $this->cronConfig = $cronConfig;
        $config = $config ?? [];
        parent::__construct($config);
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getCronConfig(): string
    {
        return $this->cronConfig;
    }

}
