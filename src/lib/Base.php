<?php 
namespace Websocket;

class Base extends AbstractBase
{
    public static function getInstance(...$args)
    {
        if (!self::$instance) {
            self::$instance = new self(...$args);
        }

        return self::$instance;
    }
}