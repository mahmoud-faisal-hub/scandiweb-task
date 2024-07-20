<?php

namespace Mahmoud\ScandiwebTask\Database\Managers\Contracts;

use PDO;

interface DatabaseManager
{
	public function connect(): PDO;

    public function query(string $query, array $params = [], $fetch = true, $model = null);

    public function create($table, $data);

    public function read($columns = "*", $table, $filter = null);

    public function update($table, $data, $column = null, $value);

    public function delete($table, $column = null, $value);

    public function grammar();
}