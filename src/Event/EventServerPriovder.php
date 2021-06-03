<?php
namespace Dartswoole\Event;

use Dartswoole\Help\Debug;
use Dartswoole\Priovder\ServerPriovder;

class EventServerPriovder extends ServerPriovder
{
    public function boot()
    {
        Debug::info('is evevt boot');
    }
}