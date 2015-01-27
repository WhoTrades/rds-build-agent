<?php
define('SCRIPT_START_TIME', microtime(true));
set_time_limit(0);
error_reporting(E_ALL && ~E_STRICT);
date_default_timezone_set('UTC');


$_SERVER['SERVER_NAME'] = 'console';
$_SERVER['REQUEST_URI'] = '/';

preg_match('/--http-host[= ]+([a-z.]+)/i', implode(' ', $_SERVER['argv']), $matches);
if (!empty($matches[1])) {
    $_SERVER['HTTP_HOST'] = $matches[1];
}

require_once __DIR__ . '/../../lib/init-libraries.php';

//$Core = Cronjob\RequestHandler\Core::getInstance(__DIR__ . "/../../")->init(array());
$Core = Cronjob\RequestHandler\Core::getInstance(__DIR__ . "/../../")->init(array());

class Config
{
    protected static $instance;

    function __construct($configLocations)
    {
        $path = dirname(__FILE__) . '/../../';
        foreach (array(
                 'config/config.db.php', // vdm: подключил т.к. он используется внутри config.pgq
                 'config/config.comon.php',
                 'config/config.taskssystem.php',
                 'config/config.servicebase.php',
                 'config/config.stm.php', // vdm: подключаем сразу после config.services.php
                 'config/config.services.php',
                 'config/config.pgq.php', // vdm: NB: см config.pgq.php
                 'config/config.cronjob.php', // ad: #WTS-855
                 'config.service.php',
                 'config.local.php',
                 ) as $configLocation) {
            if (file_exists($path . $configLocation)) {
                require $path . $configLocation;
            }
        }
        $this->cache_dir = '/var/tmp/deploy/cache/';
        $this->pid_dir = '/var/tmp/deploy/pid/';
        $this->semaphore_dir = '/var/tmp/deploy/semaphore/';
        $this->project = 'deploy';

        chdir(dirname(__FILE__));

        foreach ([$this->cache_dir, $this->pid_dir, $this->semaphore_dir] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }

    public static function createInstance($config = array())
    {
        return self::getInstance($config);
    }

    public static function getInstance($config = array())
    {
        if (null === self::$instance) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }
}

assert('!empty($requestHandlerClass)');
if (empty($requestHandlerClass)) {
    $Core->getServiceBaseDebugLogger()->error('$requestHandlerClass not specified');
    exit(Cronjob\ICronjob::EXIT_SIGNAL_UNSPECIFIED_ERROR);
}
$Core->processRequest($requestHandlerClass);
