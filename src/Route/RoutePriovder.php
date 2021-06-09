<?php
namespace Dartswoole\Route;

use Dartswoole\Help\Debug;
use Dartswoole\Priovder\PriovderInterface;

class RoutePriovder extends PriovderInterface
{
    public function boot()
    {
        Debug::info('is route boot');
    }

}