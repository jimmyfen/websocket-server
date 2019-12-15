<?php
namespace Websocket;

use Websocket\lib\Base;
use Websocket\process\ServerManage;

class App extends Base
{
    protected $host;
    protected $port;

    protected $serverManage;

    private function __construct()
    {
        $this->serverManage = ServerManage::getInstance();
    }

    /**
     * bind listen events
     *
     * @param array $callable
     * @return void
     */
    private function bind(array $callable) : void
    {
        isset($callable['open'])    && $this->serverManage->bind('open', $callable['open']);
        isset($callable['message']) && $this->serverManage->bind('message', $callable['message']);
        isset($callable['close'])   && $this->serverManage->bind('close', $callable['close']);
        isset($callable['request']) && $this->serverManage->bind('request', $callable['request']);
    }

    /**
     * run
     *
     * @param array $config
     * @param array $callable
     * @return App
     */
    public static function run(array $config = [], array $callable = []) : App
    {
        $instance = Static::getInstance();

        !empty($conf) && $instance->loadConf($config);

        $instance->bind($callable);
        $instance->exec();

        return $instance;
    }

    public function exec() : void
    {
        $this->serverManage->exec();
    }

    /**
     * load the conf
     *
     * @param array $config
     * @return void
     */
    private function loadConf(array $config = []) : void
    {
        $this->serverManage->loadConf($config);
    }

    /**
     * get swoole_websocket_server instance
     *
     * @return void
     */
    public function getServer()
    {
        return $this->serverManage->getServer();
    }
}

// websocket server root path
define('WEBSOCKET_PATH',      realpath(getcwd()));
// websocket server config path
define('WEBSOCKET_CONF_PATH', WEBSOCKET_PATH . '/conf');
// websocket log path
define('WEBSOCKET_LOG_PATH',  WEBSOCKET_PATH . '/logs');

