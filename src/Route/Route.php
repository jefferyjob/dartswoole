<?php
namespace Dartswoole\Route;

/**
 * 路由解析实现类
 * @package Dartswoole\Route
 */
class Route {

    static protected $instance;

    /**
     * 存储路由结构的数组
     */
    protected $routes = array();

    /**
     * 定义访问的类型
     */
    protected $method = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * 区分服务类型
     */
    protected $flag;

    protected $namespace;

    protected function __construct(){

    }

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
            if ($action instanceof Closure) {
                $this->routes[$this->flag][$method][$uri] = $action;
            } else {
                $this->routes[$this->flag][$method][$uri] = $this->namespace."\\".$action;
            }
        }
        return $this;
    }

    public function runAction($action)
    {

    }

}