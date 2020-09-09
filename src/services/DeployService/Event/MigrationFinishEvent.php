<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

final class MigrationFinishEvent extends \yii\base\Event
{
    /** @var string */
    private $project;

    /** @var string */
    private $version;

    /** @var array  */
    private $migrations = [];

    /** @var string */
    private $type;

    /** @var string */
    private $command;

    public function __construct(string $project, string $version, array $migrations, string $type, string $command, $config = null)
    {
        $this->project = $project;
        $this->version = $version;
        $this->migrations = $migrations;
        $this->type = $type;
        $this->command = $command;
        $config = $config ?? [];
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return $this->migrations;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }
}
