<?php

namespace Mahmoud\ScandiwebTask\Database\Managers;

use Mahmoud\ScandiwebTask\Database\Managers\Contracts\DatabaseManager;
use PDO;

class SQLiteManager implements DatabaseManager
{
	protected static $instance;

	public function connect(): PDO
    {
        // if (!self::$instance) {
        //     self::$instance = new PDO(env('DB_CONNECTION') . ':' . 'host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
        // }

        return self::$instance;
    }

    public function query(string $query, array $params = [], $fetch = true, $model = null)
    {
        //
    }

    public function create($table, $data)
    {
        //
    }

    public function read($columns = "*", $table, $filter = null)
    {
        //
    }

    public function update($table, $data, $column = null, $value)
    {
        //
    }

    public function delete($table, $column = null, $value)
    {
        //
    }

    public function grammar()
    {
        //
    }
}