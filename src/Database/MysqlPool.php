<?php
namespace Dartswoole\Database;

use Dartswoole\App\Application;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool;

/**
 * mysql连接池连接
 *
 * Class MysqlPool
 * @package Dartswoole\Database
 */
class MysqlPool
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
     * 初始化数据库连接
     *
     * wiki：https://wiki.swoole.com/#/coroutine/conn_pool
     */
    private function init()
    {
        $config = (new PDOConfig)
            ->withHost($this->config->get("database.mysql.host"))
            ->withPort($this->config->get("database.mysql.port"))
            ->withDbName($this->config->get("database.mysql.database"))
            ->withUsername($this->config->get("database.mysql.username"))
            ->withPassword($this->config->get("database.mysql.password"));
        $this->pool = new PDOPool($config, $this->config->get("database.mysql.pool.size"));
    }

    /**
     * 获取连接（连接池未满时会创建新的连接）
     *
     * @return mixed
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