<?php

use Mahmoud\ScandiwebTask\Application;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? value($default);
    }
}

if (!function_exists('app')) {
    function app()
    {
        static $instance = null;

        if (!$instance) {
            $instance = new Application;
        }

        return $instance;
    }
}

if (!function_exists('value')) {
    function value($value)
    {
        return ($value instanceof Closure) ? $value() : $value;
    }
}

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return dirname(__DIR__) . '/../' . $path;
    }
}