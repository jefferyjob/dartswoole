<?php
namespace Dartswoole\Rpc;

use Dartswoole\Priovder\PriovderInterface;

class RpcServerPriovder extends PriovderInterface
{
    protected $services;

    public function boot()
    {
        $this->provider();

        $this->app->bind('rpc-proxy', new Proxy($this->services));
    }

    protected function provider()
    {

    }
}