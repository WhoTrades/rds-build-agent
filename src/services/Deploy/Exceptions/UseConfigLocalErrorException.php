<?php
/**
 * @author Maksim Rodikov
 */
declare(strict_types=1);

namespace whotrades\RdsBuildAgent\services\Deploy\Exceptions;

use Throwable;

class UseConfigLocalErrorException extends \Exception
{
    const ERROR_CREATE_DIR          = 100;
    const ERROR_WRITE_FILE          = 101;
    const ERROR_EMPTY_UPLOAD_SCRIPT = 102;
    const ERROR_COMMAND_EXECUTOR    = 103;


    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}