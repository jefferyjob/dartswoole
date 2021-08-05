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
        $this->host = $this->app->make('config')->get('server.http.host');

        $this->port = $this->app->make('config')->get('server.http.port');
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
     *
     * mark
     * chrome请求两次问题：https://wiki.swoole.com/#/start/start_http_server?id=chrome-%e8%af%b7%e6%b1%82%e4%b8%a4%e6%ac%a1%e9%97%ae%e9%a2%98
     */
    public function onRequest($request, $response)
    {
        Debug::info("swoole http 访问成功了 #".rand(10000, 99999));

        // 处理第一次请求
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->end();
            return;
        }

        // 处理第二次请求
        $response->header('Content-Type', 'text/html; charset=utf-8');

        //$response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        $httpRequest = HttpRequest::init($request);

        $this->app->make('route')->match($httpRequest->getUriPath(),'http',$httpRequest->getMethod());

        Debug::dd('执行成功了666');
    }

}