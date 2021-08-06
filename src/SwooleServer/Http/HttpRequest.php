<?php
namespace Dartswoole\SwooleServer\Http;

use Swoole\Http\Request as SwooleRequest;

/**
 * 请求路由的解析
 *
 * Class HttpRequest
 * @package Dartswoole\SwooleServer\Http
 */
class HttpRequest
{
    protected $method; // 记录请求方式是get还是 post

    protected $uriPath; // 记录后续请求地址 / /dd /index/dd

    protected $swooleRequest;

    public function getMethod()
    {
        return $this->method;
    }

    public function getUriPath()
    {
        return $this->uriPath;
    }

    static public function init(SwooleRequest $request)
    {
        $self = new static;

        $self->swooleRequest = $request;
        $self->server = $request->server;

        $self->method = $request->server['request_method'] ?? '';
        $self->uriPath = $request->server['request_uri'] ?? '';

        return $self;
    }
}