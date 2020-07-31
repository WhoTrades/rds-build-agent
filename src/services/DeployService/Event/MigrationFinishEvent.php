<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

final class MigrationFinishEvent extends \yii\base\Event
{
    /** @var array  */
    private $migrations = [];

    public function __construct(array $migrations, $config = null)
    {
        $this->migrations = $migrations;
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
}