<?php
namespace Dartswoole\SwooleServer\Http;

use Dartswoole\Help\Debug;
use Dartswoole\SwooleServer\ServerBase;
use Swoole\Http\Server;

/**
 * swoole 实现http服务
 *
 * wiki：https://wiki.swoole.com/#/start/start_http_server
 * wiki：https://wiki.swoole.com/#/http_server
 * @package Dartswoole\Server\Http
 */

class HttpServer extends ServerBase {

    /**
     * 配置文件
     */
    public function initServerConfig()
    {

    }

    /**
     * 创建服务
     */
    public function createServer()
    {
        $this->server = new Server($this->host, $this->port);

        Debug::info("swoole http 服务启动成功：");

        Debug::info("http://{$this->host}:{$this->port}");
    }

    /**
     * 事件绑定
     */
    public function initEvent()
    {
        $this->setEvent('sub', [
            'request' => 'onRequest'
        ]);
    }

    /**
     * http 响应事件
     *
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        Debug::info("swoole http 访问成功了 #".rand(10000, 99999));

        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }

}