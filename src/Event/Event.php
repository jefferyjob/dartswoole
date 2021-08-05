<?php
namespace Dartswoole\Event;

class Event
{
    /**
     * @var array 定义所有事件
     */
    protected $events = [];

    /**
     * 注册事件
     *
     * @param $flag
     * @param $callback
     */
    public function register($flag, $callback)
    {
        $flag = strtolower($flag);

        $this->events[$flag] = array(
            'callback' => $callback
        );
    }

    /**
     * 触发事件
     *
     * @param $flag
     * @param array $params
     * @return bool
     */
    public function trigger($flag, $params = [])
    {
        $flag = strtolower($flag);

        if(isset($this->events[$flag])) {
            ($this->events[$flag]['callback'])(...$params);
            return true;
        }
    }

    /**
     * 获取所有事件
     */
    public function getEvents()
    {
        return $this->events;
    }
}