<?php
namespace Dartswoole\Event;

use Dartswoole\Help\Debug;
use Dartswoole\Priovder\PriovderInterface;

class EventPriovder extends PriovderInterface
{
    public function boot()
    {
        Debug::info('is evevt boot');
    }
}