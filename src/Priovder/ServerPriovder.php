<?php
namespace Dartswoole\Priovder;

use Dartswoole\App\Application;

abstract class ServerPriovder
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {

    }

    abstract public function boot();
}