<?php
namespace Websocket\lib;

Abstract class AbstractBase
{
    public $instance;

    private function __construct(...$args)
    {}

    public static function getInstance(...$args)
    {
        if (!Static::$instance) {
            Static::$instance = new Static(...$args);
        }

        return Static::$instance;
    }
}