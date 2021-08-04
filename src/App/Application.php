<?php
namespace Dartswoole\App;

use Dartswoole\Container\Container;
use Dartswoole\Help\ColorString;
use Dartswoole\Help\Debug;

/**
 * 框架核心注册与启动
 */
class Application extends Container {

    /**
     * @var string 定义Library类库根目录地址
     */
    protected $basePath;

    /**
     * Library类库驱动服务
     *
     * @var string[]
     */
    protected $bootstraps = array(
        Bootstrap\LoadConfig::class, // 加载配置文件
        Bootstrap\ServerPrivoder::class // 服务提供者
    );

    /**
     * 框架启动
     */
    public function __construct($path)
    {
        // 定义根目录
        if(!empty($path)) {
            $this->setBasePath($path);
        }

        // logo 展示
        Debug::info("========================\n====== DartSwoole ======\n========================");

        // 将当前类创建单例
        self::setInstance($this);
        // 加载框架驱动
        $this->bootstrap();

        // 启动成功的文本输出
        echo ColorString::getColoredString("Dartswoole Library 启动成功", 'yellow').PHP_EOL.PHP_EOL;
    }

    /**
     * 服务器启动处理php-cli命令
     *
     * @param $argv string php-cli传递的参数
     */
    public function run($argv){
        $cli = $argv[1] ?? null;
        switch (strtolower($cli)) {
            // http 服务
            case 'http:start':
                $server = new \Dartswoole\SwooleServer\Http\HttpServer($this);
                $server->start();
                break;

            // 错误的服务名称
            default:
                Debug::error("Command input error");
        }
    }

    /**
     * 加载框架的核心启动类
     */
    public function bootstrap(){
        foreach ($this->bootstraps as $key => $bootstrap) {
            (new $bootstrap())->bootstrap($this);
        }
    }

    public function getConfigPath()
    {
        return $this->getBasePath()."/config";
    }

    public function setBasePath($path)
    {
        $this->basePath = rtrim($path, '\/');
    }
    public function getBasePath()
    {
        return $this->basePath;
    }
}