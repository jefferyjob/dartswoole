<?php
namespace Dartswoole\Route;

use Dartswoole\Help\Debug;
use Dartswoole\Priovder\ServerPriovder;

class RouteServerPriovder extends ServerPriovder
{
    public function boot()
    {
        Debug::info('is route boot');
    }

}