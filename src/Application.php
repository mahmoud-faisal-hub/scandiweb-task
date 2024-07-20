<?php

namespace Mahmoud\ScandiwebTask;

use Mahmoud\ScandiwebTask\Database\DB;
use Mahmoud\ScandiwebTask\Database\Managers\MySQLManager;
use Mahmoud\ScandiwebTask\Database\Managers\SQLiteManager;
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

    protected DB $db;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigrations());
        $this->db = new DB($this->getDatabaseDriver());
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

    protected function getDatabaseDriver()
    {
        switch (env('DB_CONNECTION')) {
            case 'mysql':
                return new MySQLManager;
            case 'sqlite':
                return new SQLiteManager;
            default:
                return new MySQLManager;
        }
    }

    public function run()
    {
        $this->db->init();
        $this->route->resolve();
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}