<?php
namespace Dartswoole\Database;

use Swoole\Runtime;
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;

class DB
{
    /**
     * 获取数据库的连接
     *
     * @return mixed|object
     */
    public static function getDriver()
    {
        // 获取数据库驱动类型
        $app = app("config")->get("database.driver");

        // 获取连接
        return app($app);
    }

    /**
     * raw调用数据库
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
        $chan = new Channel(1);

        // 协程调用
        Coroutine::create(function () use ($chan, $method, $args) {

            $pdo = self::getDriver();
            // $pdo = new Mysql1;
            $return = $pdo->{$method}(...$args);
            $chan->push($return);

        });
        return $chan->pop();
    }
}