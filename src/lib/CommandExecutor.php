<?php
class CommandExecutor
{
    /** @var \ServiceBase_IDebugLogger */
	private $debugLogger;
	
	public function __construct($debugLogger)
	{
		$this->debugLogger = $debugLogger;
	}
	
	public function executeCommand($command)
	{
		$this->debugLogger->message("Executing `$command`");
		exec($command, $output, $returnVar);
		$text = implode("\n", $output);

		if ($returnVar) {
			throw new \CommandExecutorException("Return var is non-zero, code=".$returnVar.", command=$command", $returnVar, $text);
		}

		return $text;
	}
}

