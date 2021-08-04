<?php
namespace Dartswoole\App\Bootstrap;

use Dartswoole\App\Application;
use Dartswoole\Config\Config;
use Dartswoole\Help\Debug;

/**
 * 加载框架的配置文件
 */
class LoadConfig {

    /**
     * 配置文件加载
     *
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        // 此处得到的是 darts 框架下 config 目录下的所有配置文件信息
        //$config = new Config($app->getConfigPath());
        //Debug::dd($config);

        // 将darts得到的配置服务，与处理配置文件的类绑定
        $app->bind('config', new Config($app->getConfigPath()));
    }

}