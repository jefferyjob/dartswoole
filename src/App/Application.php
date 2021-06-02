<?php
namespace Dartswoole\App;

use Dartswoole\Container\Container;
use Dartswoole\Help\ColorString;
use Dartswoole\Help\Debug;

/**
 * 框架核心注册与启动
 *
 */
class Application extends Container {

    protected $basePath;

    protected $bootstraps = array(
        Bootstrap\LoadConfiguration::class,
        Bootstrap\ServerPrivoder::class
    );

    /**
     * 框架启动
     */
    public function __construct()
    {
        // logo 展示
        echo ColorString::getColoredString(self::LOGO, 'green');

        // 将该类创建单例
        self::setInstance($this);

        // 加载框架驱动
        $this->bootstrap();

        // 启动成功
        echo ColorString::getColoredString("Dartswoole 项目启动成功", 'green');
    }

    /**
     * 服务器启动处理php-cli命令
     *
     * @param $argv
     */
    public function run($argv){
        $cli = $argv[1] ?? null;
        switch (strtolower($cli)) {
            case 'http:start':
                echo 1234;
                break;
            case '':
                echo 345;
                break;
            default:
                Debug::error("Service input error");
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

    const LOGO = "
 .----------------.  .----------------.  .----------------.  .----------------.  .----------------.   
| .--------------. || .--------------. || .--------------. || .--------------. || .--------------. |  
| |  ________    | || |      __      | || |  _______     | || |  _________   | || |    _______   | |  
| | |_   ___ `.  | || |     /  \     | || | |_   __ \    | || | |  _   _  |  | || |   /  ___  |  | |  
| |   | |   `. \ | || |    / /\ \    | || |   | |__) |   | || | |_/ | | \_|  | || |  |  (__ \_|  | |  
| |   | |    | | | || |   / ____ \   | || |   |  __ /    | || |     | |      | || |   '.___`-.   | |  
| |  _| |___.' / | || | _/ /    \ \_ | || |  _| |  \ \_  | || |    _| |_     | || |  |`\____) |  | |  
| | |________.'  | || ||____|  |____|| || | |____| |___| | || |   |_____|    | || |  |_______.'  | |  
| |              | || |              | || |              | || |              | || |              | |  
| '--------------' || '--------------' || '--------------' || '--------------' || '--------------' |  
 '----------------'  '----------------'  '----------------'  '----------------'  '----------------'  
    ";
}