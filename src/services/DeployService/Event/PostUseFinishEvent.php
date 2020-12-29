<?php
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

use yii\base\Event;

class PostUseFinishEvent extends Event
{
    /** @var string */
    private $project;

    /** @var string */
    private $version;

    /** @var string */
    private $payload;

    /**
     * PostUseFinishEvent constructor.
     * @param string $project
     * @param string $version
     * @param string $payload
     * @param null $config
     */
    public function __construct(string $project, string $version, string $payload, $config = null)
    {
        $this->project = $project;
        $this->version = $version;
        $this->payload = $payload;

        $config = $config ?? [];
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getProject(): string
    {
        return $this->project;
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
