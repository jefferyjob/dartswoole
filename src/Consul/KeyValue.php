<?php
namespace Dartswoole\Consul;

/**
 * consul 的 Keu/Value 服务管理
 *
 * Class Agent
 * @package Dartswoole\Consul
 */
class KeyValue
{
    /**
     * @var object consule服务
     */
    protected $consul;

    public function __construct($consul) {
        $this->consul = $consul;
    }
}