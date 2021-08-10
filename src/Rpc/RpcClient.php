<?php
namespace Dartswoole\Rpc;

use Dartswoole\Help\Debug;
use Swoole\Coroutine\Client;
use function Couchbase\defaultDecoder;

/**
 * RPC 客户端服务相关处理
 *
 * Class RpcClient
 * @package Dartswoole\Rpc
 */
class RpcClient
{
    /**
     * @var string 类名
     */
    protected $class;

    /**
     * @var string rpc服务名称
     */
    protected $service;

    /**
     * 调用 RPC 服务端
     *
     * @param $method string 请求方法
     * @param $params array 参数
     */
    public function proxy($method, $params = array())
    {
        $data = array(
            'method' => $this->class.'::'.$method,
            'params' => $params
        );

        // 1、采用配置文件访问rpc服务
        // 获取 frame 中的配置信息
//        $config = app('config')->get('rpc_client.'.$this->service);
//        return $this->send($config['host'], $config['port'], $data);

        // 2、采用consul注册的服务访问rpc服务
        $service = app('rpc-proxy')->getService($this->service);
        return $this->send($service['host'], $service['port'], $data);

        //return $this->send('127.0.0.1', 9600, $data);
    }

    /**
     * 请求 RPC 服务
     *
     * @param $host
     * @param $port
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function send($host, $port, $data)
    {
        $client = new Client(SWOOLE_SOCK_TCP);
        if (!$client->connect($host, $port, 0.5)) {
            throw new \Exception("连接RPC服务端失败".json_encode(array(
                'host' => $host,
                'port' => $port
            )), 500);

        }
        $client->send(json_encode($data));
        $result = $client->recv();
        $client->close();
        return $result;
    }

    /**
     * 调用不存在的方法
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        return $this->proxy($name, $arguments);
    }

    /**
     * 调用不存在的静态方法
     *
     * @param $name
     * @param $arguments
     */
    static public function __callStatic($name, $arguments)
    {
        return self::proxy($name, $arguments);
    }
}