<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\DeployService\Event;

use yii\base\Event;

final class CronConfigUpdateEvent extends Event
{
    /** @var string  */
    private $cronConfig = "";

    public function __construct(string $cronConfig, $config = null)
    {
        $this->cronConfig = $cronConfig;
        $config = $config ?? [];
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getCronConfig(): string
    {
        return $this->cronConfig;
    }

}