<?php
namespace Dartswoole\Database;

use Dartswoole\Priovder\PriovderInterface;

/**
 * DB数据库服务提供者
 *
 * Class DatabaseServerPriovder
 * @package Dartswoole\Database
 */
class DatabaseServerPriovder extends PriovderInterface
{
    public function boot()
    {
        // mysql 服务绑定
        $this->app->bind('mysql',new MysqlPool($this->app));

        // redis 服务绑定 ...
        //$this->app->bind('redis',new RedisPool($this->app));
    }
}