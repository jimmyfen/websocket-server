<?php
namespace Websocket\process;

use Websocket\lib\Config;
use Websocket\lib\Base;

class Server
{
    use Base;

    protected $server;
    protected $config;
    protected $callable = [];  // bind listen event

    private function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * get config
     *
     * @return Config
     */
    public function getConfig() : Config
    {
        return $this->config;
    }

    public function start(array $options)
    {
        $config = $this->config->getConf();
        if ( !$config['HOST'] || !$config['PORT'] ) {
            throw new Exception('please set listen host or port first!');
        }

        $this->server = new \swoole_websocket_server($config['HOST'], $config['PORT']);
        isset($options['d']) && $config['SETTING']['daemonize'] = 1;
        $this->server->set($config['SETTING']);

        // listen open event
        $this->server->on('open', function($server, $request){
            isset($this->callable['open']) && call_user_func_array($this->callable['open'], [$server, $request]);
            if ( !isset($this->callable['open']) )  echo 'not listen open event' . "\n";
        });
        // listen message event
        $this->server->on('message', function($server, $frame){
            isset($this->callable['message']) && call_user_func_array($this->callable['message'], [$server, $frame]);
            if ( !isset($this->callable['message']) )  echo 'not listen message event' . "\n";
        });
        // listen close event
        $this->server->on('close', function($server, $fd){
            isset($this->callable['close']) && call_user_func_array($this->callable['close'], [$server, $fd]);
            if ( !isset($this->callable['close']) )  echo 'not listen close event' . "\n";
        });
        // listen request event
        $this->server->on('request', function($request, $response){
            isset($this->callable['request']) && call_user_func_array($this->callable['request'], [$request, $response]);
            if ( !isset($this->callable['request']) )  echo 'not listen request event' . "\n";
        });

        echo "\e[31mserver start at " . date('Y-m-d H:i:s') . ".\e[0m\n";
        $this->server->start();
    }

    /**
     * get server instance
     *
     * @return Server
     */
    public function getServer() : Server
    {
        return $this->server;
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
        $this->callable[$event] = $callback;
    }
}