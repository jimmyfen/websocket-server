<?php
namespace Websocket\process;

use Websocket\lib\Config;
use Websocket\lib\Command;
use Websocket\lib\Base;

class ServerManage
{
    use Base;

    protected $server;

    public function loadConf(array $conf = [])
    {
        $config = Config::getInstance($conf);
        $this->server = Server::getInstance($config);
    }

    /**
     * bind listen event
     *
     * @param string $event
     * @param mixed $callback
     * @return void
     */
    public function bind(string $event, $callback) : void
    {
        $this->server->bind($event, $callback);
    }

    public function exec()
    {
        try {
            Command::getInstance()->commandHandle($this->server);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * get swoole_websocket_server instance
     *
     * @return void
     */
    public function getServer()
    {
        return $this->server->getServer();
    }
}