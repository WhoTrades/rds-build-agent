<?php
define('SCRIPT_START_TIME', microtime(true));
set_time_limit(0);
date_default_timezone_set('UTC');


$_SERVER['SERVER_NAME'] = 'console';
$_SERVER['REQUEST_URI'] = '/';

preg_match('/--http-host[= ]+([a-z.]+)/i', implode(' ', $_SERVER['argv']), $matches);
if (!empty($matches[1])) {
    $_SERVER['HTTP_HOST'] = $matches[1];
}

require_once __DIR__ . '/../../vendor/autoload.php';

$Core = Cronjob\RequestHandler\Core::getInstance(__DIR__ . "/../../")->init(array());

class Config
{
    protected static $instance;

    /**
     * Config constructor.
     *
     * @param array $configLocations
     */
    public function __construct($configLocations)
    {
        $path = dirname(__FILE__) . '/../../';
        require($path . 'config.service.php');
        require($path . 'config.local.php');
        $this->cache_dir = '/var/tmp/deploy/cache/';
        $this->pid_dir = '/var/tmp/deploy/pid/';
        $this->project = 'deploy';

        chdir(dirname(__FILE__));

        foreach ([$this->cache_dir, $this->pid_dir] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }

    /**
     * @param array $config
     *
     * @return Config
     */
    public static function createInstance($config = array())
    {
        return self::getInstance($config);
    }

    /**
     * @param array $config
     *
     * @return Config
     */
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
