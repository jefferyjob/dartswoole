<?php
namespace Dartswoole\SwooleServer;

use Dartswoole\App\Application;

/**
 * swoole基础实现类
 */
abstract class ServerBase {

    /**
     * 框架核心服务
     *
     * @var \Dartswoole\App\Application
     */
    protected $app;

    /**
     * 服务的ip地址
     */
    protected $host = '0.0.0.0';

    /**
     * 服务的端口
     */
    protected $port = 9801;

    /**
     * swoole服务
     */
    protected $server;

    /**
     * swoole服务的配置
     */
    protected $serverConfig = [
        //'task_worker_num' => 0,
    ];

    /**
     * swoole事件绑定配置
     */
    protected $serverEvent = [
        "server" => [ // 有swoole的本身的事件 -- 是在swoole的整体生命周期
            'start' => 'onStart',
            'Shutdown' => 'onShutdown'
        ],
        "sub" => [], // http - websocket 是记录明确swoole服务独有的事件
        "ext" => [] // 根据用户扩展task事件
    ];

    /**
     * 初始化服务构造
     */
    public function __construct(Application $app){
        $this->app = $app;

        // 初始化服务配置
        $this->initServerConfig();

        // 创建服务
        $this->createServer();

        // 初始化绑定的事件
        $this->initEvent();

        // 设置回调函数
        $this->setSwooleEvent();
    }

    abstract public function initServerConfig();
    abstract public function createServer();
    abstract public function initEvent();

    /**
     * 启动
     *
     * @param $server
     * @throws \Exception
     */
    public function onStart($server) {
        $this->app->make('event')->trigger('swoole:start', [$this, $server]);
    }

    /**
     * 停止
     *
     * @param $server
     * @throws \Exception
     *
     * 测试用 kill -15 ，不能用 -9
     *
     * mark:
     * https://wiki.swoole.com/#/server/events?id=onshutdown
     */
    public function onShutdown($server) {
        $this->app->make('event')->trigger('swoole:stop', [$this, $server]);
    }

    /**
     * 初始化中设置swoole回调事件
     */
    protected function setSwooleEvent()
    {
        foreach ($this->serverEvent as $type => $events) {
            foreach ($events as $event => $func) {
                $this->server->on($event, [$this, $func]);
            }
        }
    }

    /**
     * 开发者配置swoole回调事件
     *
     * @param $type string 类型
     * @param $event object 事件
     */
    public function setEvent($type, $event)
    {
//        if ($type == "server") {
//            return;
//        }

        $this->serverEvent[$type] = $event;
    }

    /**
     * swoole服务启动
     */
    public function start() {
        $this->server->set($this->serverConfig); // 加载配置文件

        $this->server->start();// 启动服务
    }
}