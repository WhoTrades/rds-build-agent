<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

use yii\base\Event;

class DeployStatusEvent extends Event
{
    const TYPE_BUILDING = 'building';
    const TYPE_BUILT = 'built';
    const TYPE_INSTALLING = 'installing';
    const TYPE_INSTALLED = 'installed';
    const TYPE_POST_INSTALLED = 'post_installed';
    const TYPE_FAILED = 'failed';

    /** @var int */
    private $taskId;

    /** @var string */
    private $type;

    /** @var string */
    private $version;

    /** @var string */
    private $payload;

    public function __construct(string $type, int $taskId, string $version, string $payload = null, $config = null)
    {
        $payload = $payload ?? "";
        $this->taskId = $taskId;
        $this->type = $type;
        $this->version = $version;
        $this->payload = $payload;

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

}