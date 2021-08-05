<?php
namespace Dartswoole\Routes;

use Dartswoole\Help\Debug;

/**
 * 路由解析实现类
 *
 * @package Dartswoole\Routes
 */
class Route {

    static protected $instance;

    /**
     * 存储路由结构的数组
     */
    protected $routes = array();

    /**
     * 服务类型区分
     *
     * 例如：http、websocket
     */
    protected $flag;

    /**
     * 定义访问的类型
     */
    protected $method = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    protected $namespace;

    protected function __construct() {

    }

    /**
     * 该类的单例
     *
     * @return Route
     */
    static public function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 获取路由数组
     *
     * @return array 路由数组
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * 注册路由
     */
    public function registerRoute(array $map) {
        foreach ($map as $key => $route) {
            $this->flag = $key;
            $this->namespace = $route['namespace'];
            require_once $route['path'];
        }
        return $this;
    }

    /**
     * 添加到路由数组
     *
     * @param $methods array 请求方法
     * @param $uri string 路由地址
     * @param $action string 路由方法
     * @return $this
     */
    protected function addRoute(array $methods, $uri, $action)
    {
        foreach ($methods as $method ) {
            if ($action instanceof \Closure) {
                $this->routes[$this->flag][$method][$uri] = $action;
            } else {
                $this->routes[$this->flag][$method][$uri] = $this->namespace."\\".$action;
            }
        }
        return $this;
    }

    /**
     * 实际的运行方法
     *
     * @param $action
     */
    public function runAction($action)
    {
        if ($action instanceof \Closure) {
            return $action();
        } else {
            $arr = \explode("@", $action);
            $class = new $arr[0]();
            return $class->{$arr[1]}();
        }
    }

    /**
     * 路由请求校验的方法
     *
     * @param $pathinfo string 路径
     * @param $flag string 路由类型
     * @param $method string 路由方法
     * @return mixed|string
     */
    public function match($pathinfo, $flag, $method)
    {
        $action = null;
        // 根据传递服务标识，请求类型查找route
        foreach ($this->routes[$flag][$method] as $uri => $value) {
            // 保持route标识与pathinfo一致性
            $uri = ($uri && \substr($uri, 0, 1) != '/') ? "/".$uri : $uri;

            if ($pathinfo === $uri) {
                $action = $value;
                break;
            }
        }
        // 判断是否查找到route
        if (!empty($action)) {
            // 执行方法操作
            return $this->runAction($action);
        }
        Debug::dd($action . "# 没有查找到方法");
        return "404";
    }

    /**
     * get 请求
     *
     * @param $uri
     * @param $action
     * @return $this
     */
    public function get($uri, $action)
    {
        return $this->addRoute(['GET'], $uri, $action);
    }

    /**
     * post 请求
     *
     * @param $uri
     * @param $action
     * @return $this
     */
    public function post($uri, $action)
    {
        return $this->addRoute(['POST'], $uri, $action);
    }

    /**
     * any 请求
     *
     * @param $uri
     * @param $action
     * @return $this
     */
    public function any($uri, $action)
    {
        return $this->addRoute($this->method, $uri, $action);
    }
}