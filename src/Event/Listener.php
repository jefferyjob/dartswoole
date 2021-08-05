<?php
namespace Dartswoole\Event;

use Dartswoole\App\Application;

abstract class Listener
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string 定义注册事件的类型
     */
    protected $name = 'listener';

    // public abstract function handler();

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getName()
    {
        return $this->name;
    }
}