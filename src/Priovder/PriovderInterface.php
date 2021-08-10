<?php
namespace Dartswoole\Priovder;

use Dartswoole\App\Application;

/**
 * 服务发现与注册
 *
 * Class PriovderInterface
 * @package Dartswoole\Priovder
 */
abstract class PriovderInterface
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