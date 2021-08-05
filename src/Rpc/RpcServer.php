<?php
namespace Dartswoole\Rpc;

use Dartswoole\App\Application;
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
     */
    public function __construct(Application $app, ServerBase $serverBase)
    {
        $this->app = $app;
        $this->server = $serverBase;
        $this->config = $this->app->make('config');
    }
}