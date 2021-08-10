<?php
namespace Dartswoole\Consul;

use Dartswoole\Priovder\PriovderInterface;

class ConsulServerPriovder extends PriovderInterface
{
    public function boot()
    {
        $config = $this->app->make('config');

        // 注册 consule 的 Services 服务
        $this->app->bind('consul-agent', new Agent(
            new Consul($config->get('consul.app.host'), $config->get('consul.app.port'))
        ));

        // 注册 consule 的 Key/Value 服务
        $this->app->bind('consul-kv', new KeyValue(
            new Consul($config->get('consul.app.host'), $config->get('consul.app.port'))
        ));
    }
}