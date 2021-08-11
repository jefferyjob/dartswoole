<?php
namespace Dartswoole\Database\Driver;

use Dartswoole\App\Application;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool;

/**
 * mysql连接池的创建与管理
 *
 * --------------------------------------------------------------------------
 * 采用swoole创建mysql的连接池
 * 对于连接池进行日常的管理和维护
 * --------------------------------------------------------------------------
 */
class MysqlPoolManager
{
    /**
     * @var object application
     */
    protected $app;

    /**
     * @var array config
     */
    protected $config;

    /**
     * @var object|mixed 连接池
     */
    protected $pool;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $app->make("config");
        $this->init();
    }

    /**
     * 初始化数据库连接池
     *
     * 连接池wiki：https://wiki.swoole.com/#/coroutine/conn_pool
     */
    private function init()
    {
        // 连接配置
        $config = (new PDOConfig)
            ->withHost($this->config->get("database.mysql.host"))
            ->withPort($this->config->get("database.mysql.port"))
            ->withDbName($this->config->get("database.mysql.database"))
            ->withUsername($this->config->get("database.mysql.username"))
            ->withPassword($this->config->get("database.mysql.password"));

        // 连接池创建
        $this->pool = new PDOPool($config, $this->config->get("database.mysql.pool.size"));
    }

    /**
     * 获取连接
     *
     * @return mixed
     * 连接池未满时会创建新的连接
     */
    public function get() {
        return $this->pool->get();
    }

    /**
     * 回收连接
     *
     * @param $pdo
     * @return mixed
     */
    public function put($pdo) {
        return $this->pool->put($pdo);
    }

    /**
     * 重置连接
     *
     * @return mixed
     * 连接异常,需要重置连接池,归还一个空连接以保证连接池的数量平衡
     *
     * wiki：https://wiki.swoole.com/#/coroutine/conn_pool?id=database
     */
    public function resetPut() {
        return $this->pool->put(null);
    }
}