<?php
namespace Dartswoole\Rpc;
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

        $config = app('config')->get('rpc_client.'.$this->service);

        // 请求发送，获取rpc的服务
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);
        if (!$client->connect($config['host'], $config['port'], 0.5)) {
            throw new \Exception("连接RPC服务端失败", 500);

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