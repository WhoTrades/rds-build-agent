<?php
class CommandExecutorException extends ApplicationException
{
    public $output;

    public function __construct($message, $code, $output, $previous = null)
    {
        $this->output = $output;
        parent::__construct($message, $code, $previous);
    }
}

