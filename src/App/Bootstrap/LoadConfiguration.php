<?php
namespace Dartswoole\App\Bootstrap;

use Dartswoole\App\Application;
use Dartswoole\Config\Config;

/**
 * 加载框架的配置文件
 */
class LoadConfiguration {

    public function bootstrap(Application $app)
    {
        // $config = new Config($app->getConfigPath());
        $app->bind('config', new Config($app->getConfigPath()));
    }

}