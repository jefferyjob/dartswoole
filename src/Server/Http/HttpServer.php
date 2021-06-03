<?php
namespace Dartswoole\Server\Http;

use Dartswoole\Help\Debug;
use Dartswoole\Server\ServerBase;
use Swoole\Http\Server;

/**
 * swoole 实现http服务
 *
 * wiki：https://wiki.swoole.com/#/start/start_http_server
 * wiki：https://wiki.swoole.com/#/http_server
 * @package Dartswoole\Server\Http
 */

class HttpServer extends ServerBase {

    public function initServerConfig()
    {

    }

    public function createServer()
    {
        $this->server = new Server($this->host, $this->port);

        Debug::info("http://{$this->host}:{$this->port}");
    }

    public function initEvent()
    {
        $this->setEvent('sub', [
            'request' => 'onRequest'
        ]);
    }

    public function onRequest($request, $response)
    {
        Debug::info("成功了");
        //$response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }

}