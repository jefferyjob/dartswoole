<?php
use Dartswoole\App\Application;

if (!function_exists('app')) {
    function app($target = null)
    {
        if (empty($target)) {
            return Application::getInstance();
        }
        return Application::getInstance()->make($target);
    }
}