<?php

namespace Mahmoud\ScandiwebTask\Database;

use Mahmoud\ScandiwebTask\Database\Concerns\ConnectsTo;
use Mahmoud\ScandiwebTask\Database\Managers\Contracts\DatabaseManager;

class DB
{
	protected DatabaseManager $manager;
    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function init()
    {
        ConnectsTo::connect($this->manager);
    }

    protected function raw(string $query, $params = [], $fetch = true, $model = null)
    {
        return $this->manager->query($query, $params, $fetch, $model);
    }

    protected function read($columns = "*", $table, $filter = null)
    {
        return $this->manager->read($columns, $table, $filter);
    }

    protected function create($table, array $data)
    {
        return $this->manager->create($table, $data);
    }

    protected function update($table, $data, $column, $value)
    {
        return $this->manager->update($table, $data, $column, $value);
    }

    protected function delete($table, $column, $value)
    {
        return $this->manager->delete($table, $column, $value);
    }

    protected function grammar()
    {
        return $this->manager->grammar();
    }

    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }
    }
}