<?php
namespace Dartswoole\App\Bootstrap;

use Dartswoole\App\Application;
use Dartswoole\Help\Debug;

/**
 * 服务提供者
 */
class ServerPrivoder
{
    public function bootstrap(Application $app)
    {
        // 获取 darts 框架中 dartswoole.php 中的 priovders 配置信息
        $priovders = $app->make('config')->get('dartswoole.priovders');

        // 服务注册 register
        foreach ($priovders as $key => $priovder) {
            (new $priovder($app))->register();
        }
        // 服务启动 boot
        foreach ($priovders as $key => $priovder) {
            (new $priovder($app))->boot();
        }
    }

}