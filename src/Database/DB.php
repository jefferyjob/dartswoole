<?php
namespace Dartswoole\Database;

use Dartswoole\Database\Driver\MysqlDriverPdo;
use Swoole\Runtime;
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;

/**
 * DB数据库静态操作支持
 *
 * --------------------------------------------------------------------------
 * 使用 DB:xx 调用操作数据库
 *
 * --------------------------------------------------------------------------
 */
class DB
{
    /**
     * 获取数据库的连接
     *
     * @return mixed|object
     */
    public static function getDriver()
    {
        // 获取数据库驱动类型-> mysql
        $driver = app("config")->get("database.driver");

        // 使用DB驱动必须是mysql
        if($driver != 'mysql') {
            throw new  \Exception("Database driver must be 'mysql'", 500);
        }

        // 从容器中获取 mysql
        return app($driver);
    }

    /**
     * DB 调用数据库
     *
     * @param $method string 请求方法
     * @param $args mixed 请求参数
     * @return mixed
     */
    static public function __callStatic($method, $args)
    {
        // 一键协程化
        Runtime::enableCoroutine();

        // 定义管道
        $channel = new Channel(1);

        // 协程调用
        Coroutine::create(function () use ($channel, $method, $args) {

            // pdo 方式
            //$pdo = new MysqlDriverPdo;

            // pool 连接池方式
            $pdo = self::getDriver();

            $return = $pdo->{$method}(...$args);
            $channel->push($return);

        });

        // 获取sql结果
        return $channel->pop();
    }
}