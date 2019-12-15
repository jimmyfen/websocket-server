<?php
namespace Websocket\lib;

use Websocket\process\Server;

class Command extends Base
{
    /**
     * run server
     *
     * @param Server $server
     * @return void
     */
    public function commandHandle(Server $server) : void
    {
        list($command, $options) = $this->commandParse();

        switch ( $command ) {
            case 'start':
                $server->start($options);
                break;
            case 'stop':
                $this->serverStop($server); 
                break;
            case 'reload':
                $this->serverReload($server);
                break;
            case '--help':
            case '-h':
            case 'help':
            case 'h':
            default:
                showHelp();
                break;
        }
    }

    /**
     * parse command params
     * @return array
     */
    private function commandParse() : array
    {
        global $argv;

        $command = '';
        $options = [];
        if ( isset($argv[1]) ) {
            $command = $argv[1];
        }

        foreach ( $argv as $item ) {
            if ( substr($item, 0, 2) === '--' ) {
                $temp          = trim($item, "--");
                $temp          = explode("-", $temp);
                $key           = array_shift($temp);
                $options[$key] = array_shift($temp) ?: '';
            }
        }

        return [ $command, $options ];
    }

    /**
     * stop server
     * @param Server $server
     * @return void
     */
    function serverStop(Server $server)
    {
        $conf = $server->getConfig()->getConf();
        $pid_file = $conf['SETTING']['pid_file'];

        if ( is_file($pid_file) ) {
            $pid = file_get_contents($pid_file);
        }

        if ( !isset($pid) ||  !swoole_process::kill($pid, 0) ) {
            echo "\e[31m 进程：{$pid}不存在.\e[0m\n";
            return;
        }

        swoole_process::kill($pid);

        $time = time();
        while ( true ) {
            usleep(1000);
            if ( !swoole_process::kill($pid, 0) ) {
                echo "\e[31mserver stop at " . date('Y-m-d H:i:s') . ".\e[0m\n";
                if ( is_file($pid_file) ) {
                    @unlink($pid_file);
                }
                break;
            }
            
            if ( time() - $time > 5 ) {
                echo "\e[31mstop server fail,please try again\e[0m\n";
                break;
            }
        }
    }

    /**
     * server reload
     *
     * @param Server $server
     * @return void
     */
    function serverReload(Server $server) : void
    {
        $conf = $server->getConfig()->getConf();
        $pid_file = $conf['SETTING']['pid_file'];

        if ( is_file($pid_file) ) {
            $pid = file_get_contents($pid_file);
        }

        if ( !isset($pid) ||  !swoole_process::kill($pid, 0) ) {
            echo "\e[31m 进程：{$pid}不存在.\e[0m\n";
            return;
        }

        swoole_process::kill($pid, SIGUSR2);
        echo "\e[31mserver reload at" . date('Y-m-d H:i:s') . ".\e[0m\n";
    }

    /**
     * show help
     *
     * @return void
     */
    function showHelp()
    {
        echo <<<HELP
\e[33m用法：
\e[31m    php server (start|stop|reload) (--d)\e[0m
\e[33m参数说明：\e[0m
\e[37m    \e[36mstart\e[0m   启动进程 接入--d表示以守护进程方式运行\e[0m
\e[37m    \e[36mstop\e[0m    结束进程\e[0m
\e[37m    \e[36mreload\e[0m  重启进程\e[0m\n
HELP;
    }
}