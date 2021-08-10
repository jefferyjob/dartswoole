<?php
namespace Dartswoole\Consul;

use Swoole\Coroutine\Http\Client;

/**
 * consul服务定义
 *
 * Class Consul
 * @package Dartswoole\Consul
 */
class Consul
{
    /**
     * @var string 服务ip
     */
    protected $host;

    /**
     * @var int 服务端口
     */
    protected $port;

    public function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * request 请求
     *
     * @param $method string 请求方法
     * @param $uri string 请求地址
     * @param null|array $options 请求参数
     *
     * wiki：https://wiki.swoole.com/#/coroutine_client/http_client
     */
    private function request($method, $uri, $options = null)
    {
        $client = new Client($this->host, $this->port);
        $client->set(['timeout' => 1]);
        $client->setMethod($method);
        if($options) {
            $client->setData(json_encode($options['body']));
        }
        $client->execute($uri);

        // 获取返回
        $headers = $client->headers;
        $statusCode = $client->statusCode;
        $body = $client->body;

        $client->close();

        return self::response($headers, $body, $statusCode);
    }

    /**
     * 返回数据处理
     *
     * @param array $header header头
     * @param string $body 返回内容
     * @param int $statuc 状态
     */
    public function response(array $header, string $body, int $status = 200)
    {
        if (empty($body)) {
            return $body;
        }
        return json_decode($body, true);
    }

    public function get(string $url = null, array $options = [])
    {
        return $this->request('GET', $url, $options);
    }

    public function delete(string $url, array $options = [])
    {
        return $this->request('DELETE', $url, $options);
    }

    public function put(string $url, array $options = [])
    {
        return $this->request('PUT', $url, $options);
    }

    public function patch(string $url, array $options = [])
    {
        return $this->request('PATCH', $url, $options);
    }

    public function post(string $url, array $options = [])
    {
        return $this->request('POST', $url, $options);
    }

    public function options(string $url, array $options = [])
    {
        return $this->request('OPTIONS', $url, $options);
    }
}