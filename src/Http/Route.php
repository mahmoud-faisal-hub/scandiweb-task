<?php

namespace Mahmoud\ScandiwebTask\Http;

class Route
{
    protected Request $request;

    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected static array $routes = [];

    public static function get($route, $action)
    {
        self::$routes['get'][$route] = $action;
    }

    public static function post($route, $action)
    {
        self::$routes['post'][$route] = $action;
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action = self::$routes[$method][$path]?? false;

        if (!array_key_exists($path, self::$routes[$method])) {
            return "404";
        }
        
        if (!$action) {
            return;
        }

        if (is_callable($action)) {
            call_user_func_array($action, []);
        }
    }
}