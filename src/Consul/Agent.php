<?php
namespace Dartswoole\Consul;

/**
 * consul 的 Services 服务管理
 *
 * Class Agent
 * @package Dartswoole\Consul
 */
class Agent
{
    /**
     * @var object consule服务
     */
    protected $consul;

    public function __construct($consul) {
        $this->consul = $consul;
    }

    /**
     * 获取所有的服务
     *
     * @return mixed
     */
    public function services() {
        return $this->consul->get('/v1/agent/services');
    }

    /**
     * 获取健康的服务
     *
     * @param $consul_name string 服务名称
     */
    public function health($consul_name) {
        return $this->consul->get("/v1/health/service/{$consul_name}?passing=true");
    }

    /**
     * 注册服务
     *
     * @param array $service
     * @return mixed
     */
    public function registerService(array $service)
    {
        return $this->consul->put('/v1/agent/service/register', array(
            'body' => $service
        ));
    }

    /**
     * 注销服务
     *
     * @param string $service_id
     * @return mixed
     */
    public function deregisterService(string $service_id)
    {
        return $this->consul->put('/v1/agent/service/deregister/' . $service_id);
    }
}