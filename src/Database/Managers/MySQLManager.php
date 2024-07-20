<?php

namespace Mahmoud\ScandiwebTask\Database\Managers;

use App\Models\Model;
use Mahmoud\ScandiwebTask\Database\Grammars\MySQLGrammar;
use Mahmoud\ScandiwebTask\Database\Managers\Contracts\DatabaseManager;
use PDO;

class MySQLManager implements DatabaseManager
{
    protected static $instance;

	public function connect(): PDO
    {
        if (!self::$instance) {
            self::$instance = new PDO(env('DB_CONNECTION') . ':' . 'host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
        }

        return self::$instance;
    }

    public function query(string $query, array $params = [], $fetch = true, $model = null)
    {
        $stmt = self::$instance->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }

        $executed = $stmt->execute();

        if ($fetch) {
            if ($model) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, $model::getModel());
            }
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $executed;
    }

    public function create($table, $data)
    {
        $query = MySQLGrammar::buildInsertQuery($table, array_keys($data));

        $stmt = self::$instance->prepare($query);

        $position = 1;
        foreach ($data as $value) {
            $stmt->bindValue($position, $value);
            $position++;
        }

        $stmt->execute();
    }

    public function read($columns = "*", $table, $filters = null)
    {
        $query = MySQLGrammar::buildSelectQuery($columns, $table, $filters);

        $stmt = self::$instance->prepare($query);

        if ($filters) {
            foreach ($filters as $index => $filter) {
                $stmt->bindValue($index + 1, $filter[2]);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Model::getModel());
    }

    public function update($table, $data, $column = null, $value)
    {
        $query = MySQLGrammar::buildUpdateQuery($table, array_keys($data), $column);

        $stmt = self::$instance->prepare($query);

        $position = 1;
        foreach ($data as $val) {
            $stmt->bindValue($position, $val);
            $position++;
        }
        
        $stmt->bindValue(count($data) + 1, $value);

        $updated = $stmt->execute();

        return $updated;
    }

    public function delete($table, $column = null, $value)
    {
        $query = MySQLGrammar::buildDeleteQuery($table, $column);

        $stmt = self::$instance->prepare($query);

        $stmt->bindValue(1, $value);

        return $stmt->execute();
    }

    public function grammar()
    {
        return MySQLGrammar::class;
    }
}