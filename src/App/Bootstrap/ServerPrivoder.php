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
        $priovders = $app->make('config')->get('dartswoole.priovders');

        // 先是 register
        foreach ($priovders as $key => $priovder) {
            (new $priovder($app))->register();
        }
        // 先是 boot
        foreach ($priovders as $key => $priovder) {
            (new $priovder($app))->boot();
        }
    }

}