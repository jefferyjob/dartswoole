<?php
namespace Dartswoole\Routes;

use Dartswoole\Help\Debug;
use Dartswoole\Priovder\PriovderInterface;

class RouteServerPriovder extends PriovderInterface
{
    /**
     * @var array 记录路由文件配置信息
     */
    protected $map = [];

    public function boot()
    {
        // test
        //Debug::info('is route boot');

        // 注册路由
        $this->app->bind('route', Route::getInstance()->registerRoute($this->map));

        // test：获取所有路由信息
        Debug::dd($this->app->make("route")->getRoutes());
    }

}