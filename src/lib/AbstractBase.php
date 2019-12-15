<?php
namespace Websocket\lib;

Abstract class AbstractBase
{
    private static $instance;

    Abstract public static function getInstance(...$args);
}