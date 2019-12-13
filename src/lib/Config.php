<?php
namespace Websocket\lib;

/**
 * config
 */
class Config extends AbstractBase
{
    protected $config;

    /**
     * loading config
     *
     * @param array $config
     */
    private function __construct(array $config = [])
    {
        $this->config = include(WEBSOCKET_PATH . '/conf/config.php');
        $this->setConf($config);
    }

    /**
     * add\edit config
     *
     * @param array $config
     * @return Config
     */
    public function setConf(array $config = []) : Config
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    /**
     * get config
     *
     * @param mixed $key
     * @return mixed
     */
    public function getConf($key = null)
    {
        if ( is_null($key) ) {
            return $this->config;
        }

        if ( isset($this->config[$key]) ) {
            return $this->config[$key];
        }

        return null;
    }
}