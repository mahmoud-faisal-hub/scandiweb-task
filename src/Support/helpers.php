<?php

use Mahmoud\ScandiwebTask\Application;
use Mahmoud\ScandiwebTask\Http\Request;
use Mahmoud\ScandiwebTask\Http\Response;

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

if (!function_exists('config_path')) {
    function config_path()
    {
        return base_path('config/');
    }
}

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->config;
        }

        if (is_array($key)) {
            return app()->config->set($key);
        }

        return app()->config->get($key, $default);
    }
}

if (!function_exists('request')) {
    function request($key = null)
    {
        $instance = new Request();

        if ($key) {
            return $instance->get($key);
        }

        if (is_array($key)) {
            return app()->config->only($key);
        }

        return $instance;
    }
}

if (!function_exists('response')) {
    function response()
    {
        $instance = new Response();

        return $instance;
    }
}

if (!function_exists('back')) {
    function back()
    {
        return response()->back();
    }
}

if (!function_exists('abort')) {
    function abort($code, $message = '', array $params = [])
    {
        $response = response();
        $response->setStatusCode($code);

        echo $response->json(array_merge(['message' => $message], $params));

        exit;
    }
}

if (!function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
