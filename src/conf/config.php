<?php
return [
    'HOST'     => '0.0.0.0',  // host
    'PORT'     => 9501,       // port
    'SETTING'  =>  [
        'max_request' => 1000,
        'work_num'    => 2,
        'pid_file'    => WEBSOCKET_CONF_PATH . '/server.pid',
        'log_file'    => WEBSOCKET_LOG_PATH . '/console-' . date('Ymd') . '.log'
    ]
];