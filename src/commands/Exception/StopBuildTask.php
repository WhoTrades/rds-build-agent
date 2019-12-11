<?php
namespace whotrades\RdsBuildAgent\commands\Exception;

class StopBuildTask extends \Exception
{
    protected $signo;

    public function __construct($signo)
    {
        $this->signo = $signo;

        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getSigno()
    {
        return $this->signo;
    }
}
