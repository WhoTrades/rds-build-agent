<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\Deploy\Exceptions;

use Throwable;

class UseProjectVersionErrorException extends \Exception
{
    const ERROR_EMPTY_USE_SCRIPT    = 100;
    const ERROR_WRITE_FILE          = 101;
    const ERROR_COMMAND_EXECUTOR    = 102;


    /** @var int  */
    protected $releaseRequestId;
    /** @var string  */
    protected $initiatorUserName;

    public function __construct($message = "", $code = 0, Throwable $previous = null, int $releaseRequestId = 0, string $initiatorUserName = '')
    {
        $this->releaseRequestId = $releaseRequestId;
        $this->initiatorUserName = $initiatorUserName;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    final public function getReleaseRequestId(): int
    {
        return $this->releaseRequestId;
    }

    /**
     * @return string
     */
    final public function getInitiatorUserName(): string
    {
        return $this->initiatorUserName;
    }

}