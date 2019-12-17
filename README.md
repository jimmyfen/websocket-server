# websocket-server
websocket server based on swoole
### 使用此插件可以减少处理websocket层面的代码，更加专注业务层面的代码


## 
## **一、安装**

### &nbsp;&nbsp;&nbsp;&nbsp;1. 环境
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`PHP >= 7.0.0`
### 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`swoole >= 1.7.9`
### 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`composer`

### &nbsp;&nbsp;&nbsp;&nbsp;2. 安装
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`composer require jimmyfen/websocket-server`

## **二、配置**
```PHP
    array(
        'HOST' => '0.0.0.0',  // 绑定监听域名
        'PORT' => 9501,       // 绑定监听端口
        'SETTING' => array(
            ...               // 此处为swoole设置参数，详情参考swoole文档
        )
    )
```

## **三、项目目录**
```
    src
     |-------conf        // 配置文件，可在此查看默认配置
     |-------lib   
     |-------logs        // 默认swoole日志文件位置，若不存在且未改配置需手动创建
     |-------process     
```

## **四、基本使用**
```PHP
// 文件index.php
<?php

require './vendor/autoload.php';

function onOpen($server, $request){
    // do something
}

function onMessage($server, $frame){
    // do something
}

function onClose($server, $fd){
    // do something
}

function onRequest($request, $response){
    // do something
}

// 监听事件，参考swoole文档(函数可以是对象对应的方法，参考call_user_func_array()函数)
$callable = [
    'open' => 'onOpen',
    'message' => 'onMessage',
    'close' => 'onClose',
    'request' => 'onRequest'
];
// 配置项，SETTING部分参考swoole文档
$config = [
    'HOST' => '0.0.0.0',
    'PORT' => 9501,
    'SETTING' => [
        'max_request' => 1000,
        'work_num' => 2,
        'pid_file' => './server.pid',
        'log_file' => './console.log'
    ]
];

\Websocket\App::run($callable, $config);
?>
// 运行：php index.php start(不加参数可以看到具体的参数介绍)
```

## **五、参考资料**
### &nbsp;&nbsp;&nbsp;&nbsp;[1. swoole官方文档](https://wiki.swoole.com)
### &nbsp;&nbsp;&nbsp;&nbsp;[2. PHP call_user_func_array函数文档](https://www.php.net/manual/zh/function.call-user-func-array.php)
