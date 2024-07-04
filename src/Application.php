<?php

namespace Mahmoud\ScandiwebTask;

use Mahmoud\ScandiwebTask\Http\Request;
use Mahmoud\ScandiwebTask\Http\Response;
use Mahmoud\ScandiwebTask\Http\Route;

class Application
{
    protected Request $request;
	protected Response $response;
	protected Route $route;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
    }

    public function run()
    {
        $this->route->resolve();
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}