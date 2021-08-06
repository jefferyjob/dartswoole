<?php
namespace Dartswoole\Rpc;

use Dartswoole\App\Application;
use Dartswoole\Help\Debug;
use Dartswoole\SwooleServer\Reponse;
use Dartswoole\SwooleServer\ServerBase;

class RpcServer
{
    /**
     * @var object 核心服务
     */
    protected $app;

    /**
     * @var array 配置文件
     */
    protected $config;

    /**
     * @var object 服务
     */
    protected $server;

    /**
     * @var int 监听端口
     */
    protected $listen;

    /**
     * 构造方法
     * 初始化加载必要配置和服务
     *
     * RpcServer constructor.
     * @param Application $app
     * @param ServerBase $serverBase
     * @throws \Exception
     *
     * mark：
     * 多端口监听：https://wiki.swoole.com/#/server/port?id=%e5%a4%9a%e7%ab%af%e5%8f%a3%e7%9b%91%e5%90%ac
     */
    public function __construct(Application $app, ServerBase $serverBase)
    {
        $this->app = $app;
        $this->server = $serverBase;
        $this->config = $this->app->make('config');

        // swoole 多端口监听
        $this->listen = $serverBase->getServer()->listen($this->config->get('server.rpc.host'),$this->config->get('server.rpc.port'),$this->config->get('server.rpc.type'));

        // 事件监听
        $this->listen->on('Connect', [$this, 'Connect']);
        $this->listen->on('Receive', [$this, 'Receive']);
        $this->listen->on('Close', [$this, 'Close']);

        // swoole 配置重置
        $this->listen->set($this->config->get('server.rpc.swoole'));

        Debug::info('RPC 服务启动成功');
        Debug::info('tcp://'.$this->config->get('server.rpc.host').':'.$this->config->get('server.rpc.port'));
    }

    /**
     * 监听连接进入事件
     *
     * @param $server
     * @param $fd
     */
    public function Connect($server, $fd)
    {
        Debug::info('RPC 连接成功');
    }

    /**
     * 监听数据接收事件
     *
     * @param $server
     * @param $fd
     * @param $reactor_id
     * @param $data
     *
     * RPC 服务端调用思路：
     * rpc client 请求过来是一个jsno
     * 解析这个json
     * 然后实例化类和调用方法
     * 得到的结果进行返回
     *
     * RPC 得到的json示例：
     * wiki：https://www.swoft.org/documents/v2/core-components/rpc-server/#-swoft-
     * {
     *   "jsonrpc": "2.0",
     *   "method": "{class_name}::{method_name}",
     *   "params": [],
     *   "id": "",
     *   "ext": []
     *   }
     */
    public function Receive($server, $fd, $reactor_id, $data)
    {
        $rpc = json_decode($data, true);
        if($rpc) {
            // 得到对象
            $class = explode("::", $rpc['method'])[0];
            $class = new $class();
            // 得到方法
            $method = explode("::", $rpc['method'])[1];
            // 执行
            $return = $class->{$method}(...$rpc['params']);
            // 返回
            $server->send($fd, Reponse::send($return));
        }

        Debug::info('RPC 收到消息并且处理:::'.Reponse::send($return));
    }

    /**
     * 监听连接关闭事件
     *
     * @param $server
     * @param $fd
     */
    public function Close($server, $fd)
    {
        Debug::info('RPC 关闭连接');
    }
}