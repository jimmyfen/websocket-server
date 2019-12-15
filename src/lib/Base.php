<?php 
namespace Websocket\lib;

trait Base
{
    private static $instance;
    
    public static function getInstance(...$args)
    {
        if (!Static::$instance) {
            Static::$instance = new Static(...$args);
        }

        return Static::$instance;
    }
}