<?php
namespace Dartswoole\Rpc;

/**
 * RPC代理服务
 *
 * 用于获取 consul 的 services 服务源
 *
 * Class Proxy
 * @package Dartswoole\Rpc
 */
class Proxy
{
    /**
     * @var string consul服务源
     */
    protected $services;

    public function __construct($services = null)
    {
        $this->services = $services;
    }

    /**
     * 获取服务信息
     *
     * @param $consul_name string 服务名称
     */
    public function services($consul_name) {
        if(is_array($this->services)) {
            return $this->services;
        }

        if($this->services instanceof \Closure) {
            return ($this->services)($consul_name);
        }

        if (empty($this->services)) {
            return app('config')->get('rpc_client.'.$consul_name);
        }
    }

    /**
     * 获取具体要请求的服务
     *
     * @param string $consul_name
     * @return mixed|string
     */
    public function getService($consul_name = '')
    {
        $services = $this->services($consul_name);
        return $services[array_rand($services, 1)];
    }
}