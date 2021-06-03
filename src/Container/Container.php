<?php
namespace Dartswoole\Container;

use \Exception;

class Container {

    // 框架服务单例
    protected static $instance;

    protected $bindings = []; // 容器服务绑定
    protected $instances = []; // 容器内其他服务单例

    /**
     * 容器绑定
     *
     * @param $abstract {abstract} 抽象类
     * @param $object object 类的实体对象
     *
     * mark：绑定的对象可以是字符串、闭包、对象
     */
    public function bind($abstract, $object) : void {
        $this->bindings[$abstract] = $object;
    }

    /**
     * 从bind容器中解析服务
     *
     * @param $abstract {abstract} 抽象类的类名
     * @param array $parameters 服务名称
     */
    public function make($abstract, $parameters = []) {
        // 通过抽象类的名称返回实体对象object
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // 判断object不存在容器中
        if (!$this->has($abstract)) {
            throw new Exception("Not Found Container Object ({$abstract})", 500);
        }

        // 取出object
        $object = $this->bindings[$abstract];

        // 判断是否为闭包
        if ($object instanceof \Closure) {
            return $object;
        }

        return $this->instances[$abstract] = (is_object($object)) ? $object :  new $object(...$parameters) ;
    }

    /**
     * 判断object是否存在于容器中
     *
     * @param $abstract
     * @return bool
     */
    public function has($abstract)
    {
        return isset($this->bindings[$abstract]);
    }

    /**
     * 创建单例模式
     *
     * @param null $container
     * @return mixed|null
     */
    public static function setInstance($container = null)
    {
        return static::$instance = $container;
    }

    /**
     * 获取单例模式
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}