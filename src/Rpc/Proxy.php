<?php
namespace Dartswoole\Rpc;

use Dartswoole\Help\Debug;

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
            throw new  \Exception("RPC services function not found", 500);
            // return app('config')->get('rpc_client.'.$consul_name);
        }
    }

    /**
     * 获取具体要请求的 rpc 服务
     *
     * @param string $consul_name
     * @return mixed|string
     */
    public function getService($consul_name = '')
    {
        $services = $this->services($consul_name);
        if(empty($services)){
            throw new  \Exception("RPC Service Not Found", 500);
        }
        return $services[array_rand($services, 1)];
    }
}