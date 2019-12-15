<?php
namespace Websocket\lib;

Abstract class AbstractBase
{
    public static $instance;

    private function __construct(...$args)
    {}

    public static function getInstance(...$args)
    {
        if (!self::$instance) {
            self::$instance = new self(...$args);
        }

        return self::$instance;
    }
}