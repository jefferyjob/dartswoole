<?php
namespace Dartswoole\Database;

use Dartswoole\Database\Driver\MysqlDriverPool;
use Dartswoole\Database\Driver\MysqlDriverPdo;
use Dartswoole\Database\Driver\MysqlPoolManager;
use Dartswoole\Priovder\PriovderInterface;

/**
 * DB数据库服务提供者
 *
 * --------------------------------------------------------------------------
 * 注册mysql的服务驱动
 * 绑定对应的mysql驱动类型
 * --------------------------------------------------------------------------
 */
class DatabaseServerPriovder extends PriovderInterface
{
    /**
     * 服务启动
     *
     * --------------------------------------------------------------------------
     * 测试[mysql pdo]
     * 取消 [mysql-pdo-服务绑定] 的注释
     * 取消 [DB.php/__callStatic/$pdo = new MysqlDriverPdo;] 的注释
     * 添加 [DB.php/__callStatic/$pdo = self::getDriver();] 的注释
     * --------------------------------------------------------------------------
     * 测试[mysql pool]进程池
     * 取消 [mysql-pool-服务绑定] 的注释
     * 添加 [DB.php/__callStatic/$pdo = new MysqlDriverPdo;] 的注释
     * 添加 [DB.php/__callStatic/$pdo = self::getDriver();] 的注释
     * --------------------------------------------------------------------------
     */
    public function boot()
    {
        // mysql-pdo-服务绑定
        //$this->app->bind('mysql',new MysqlDriverPdo());

        // mysql-pool-服务绑定
        $this->app->bind('mysql',new MysqlDriverPool(new MysqlPoolManager($this->app)));

        // redis 服务绑定 ...
        //$this->app->bind('redis', ...);
    }
}