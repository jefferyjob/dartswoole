<?php
namespace Dartswoole\Event;

use Dartswoole\Config\Config;
use Dartswoole\Help\Debug;
use Dartswoole\Priovder\PriovderInterface;

class EventServerPriovder extends PriovderInterface
{
    public function boot()
    {
        // test
        // Debug::info('is evevt boot');

        $event = new Event();

        $config = $this->app->make('config');

        // 根据 frame 中 app/config/event.php
        // 中 Listeners 的配置加载事件
        $this->registerListeners($event, $config);
        // 根据 frame 中 app/config/event.php
        // 中 event 的配置加载事件
        $this->registerEvents($event, $config);

        $this->app->bind('event', $event);

        //Debug::dd($this->app->make('event')->getEvents());
    }

    /**
     * 根据 frame 中 app/config/event.php
     * 中 Listeners 的配置加载事件
     *
     * @param Event $event
     * @param Config $config
     */
    public function registerListeners(Event $event, Config $config)
    {
        $listeners = $config->get('event.listeners');

        foreach ($listeners as $key => $listener)
        {
            $files = scandir($this->app->getBasePath().$listener['path']);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $class = $listener['namespace'].explode('.',$file)[0];

                if(class_exists($class)) {
                    //Debug::dd($class);
                    $listener = new $class($this->app);
                    $event->register($listener->getName(),array($listener,'handler'));
                } else {
                    Debug::error($class.' Event Not Found');
                }
            }
        }
    }

    /**
     * 根据 frame 中 app/config/event.php
     * 中 event 的配置加载事件
     *
     * @param Event $event
     * @param Config $config
     */
    public function registerEvents(Event $event, Config $config)
    {
        $events = $config->get('event.events');
        // var_dump($events);
        foreach ($events as $class) {
            if (class_exists($class)) {
                // Debug::dd($class."添加");
                $listener = new $class($this->app);
                $event->register($listener->getName(), [$listener, 'handler']);
            } else {
                Debug::error($class.' Event Not Found');
            }
        }
    }
}