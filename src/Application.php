<?php

namespace Mahmoud\ScandiwebTask;

use Mahmoud\ScandiwebTask\Http\Request;
use Mahmoud\ScandiwebTask\Http\Response;
use Mahmoud\ScandiwebTask\Http\Route;
use Mahmoud\ScandiwebTask\Support\Config;

class Application
{
    protected Request $request;

	protected Response $response;

	protected Route $route;

    protected Config $config;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigrations());
    }

    protected function loadConfigrations()
    {
        foreach (scandir(config_path()) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $filename = explode('.', $file)[0];

            yield $filename => require config_path() . $file;
        }
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