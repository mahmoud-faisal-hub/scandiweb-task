<?php

namespace Mahmoud\ScandiwebTask\Http;

use ReflectionFunction;
use ReflectionMethod;

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
        self::$routes['get'][] = ['route' => $route, 'action' => $action];
    }

    public static function post($route, $action)
    {
        self::$routes['post'][] = ['route' => $route, 'action' => $action];
    }

    public static function delete($route, $action)
    {
        self::$routes['delete'][] = ['route' => $route, 'action' => $action];
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $routeData = $this->findRoute($method, $path);

        if (!$routeData) {
            abort(404, '404 Not Found');
        }

        [$action, $params] = $routeData;

        if (is_array($action)) {
            [$controller, $method] = $action;
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $method)) {
                    $response = call_user_func_array([$controllerInstance, $method], $this->resolveMethodParameters([$controllerInstance, $method], $params));
                    if ($response) {
                        echo $response;
                    }
                }
            }
        } else if (is_callable($action)) {
            $response = call_user_func_array($action, $this->resolveMethodParameters($action, $params));
            if ($response) {
                echo $response;
            }
        }
    }

    protected function findRoute($method, $path)
    {
        // Normalize the path by removing trailing slash except for root "/"
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        foreach (self::$routes[$method] as $route) {
            $routePath = $route['route'];
            $routeAction = $route['action'];

            // Add optional trailing slash to the route pattern
            $routePattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\w+)', $routePath);
            $routePattern = str_replace('/', '\/', $routePattern);
            $regex = '/^' . $routePattern . '\/?$/';

            if (preg_match($regex, $path, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                return [$routeAction, $params];
            }
        }

        return false;
    }

    protected function resolveMethodParameters($action, $params)
    {
        $reflection = is_array($action) ? new ReflectionMethod($action[0], $action[1]) : new ReflectionFunction($action);
        $resolvedParams = [];

        foreach ($reflection->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $params)) {
                $resolvedParams[] = $params[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $resolvedParams[] = $parameter->getDefaultValue();
            } else {
                $resolvedParams[] = null;
            }
        }

        return $resolvedParams;
    }
}
