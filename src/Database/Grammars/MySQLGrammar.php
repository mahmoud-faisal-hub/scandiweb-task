<?php

namespace Mahmoud\ScandiwebTask\Database\Grammars;

use App\Models\Model;
use Mahmoud\ScandiwebTask\Database\Grammars\Contracts\DatabaseGrammar;

class MySQLGrammar implements DatabaseGrammar
{
    public static function buildSelectQuery($columns = "*", $table, $filters = null)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT {$columns} FROM `{$table}`";

        if (!empty($filters)) {
            $query .= ' WHERE ';
            foreach ($filters as $key => $filter) {
                if ($key > 0) {
                    $query .= ' AND ';
                }
                $query .= "{$filter[0]} {$filter[1]} ?";
            }
        }

        return $query;
    }

    public static function buildConditionQuery($column, $operator, $booleanOperator = null, $startScope = false, $endScope = false)
    {
        $query = ' ';

        if ($startScope) {
            $query .= '(';
        }

        if (!$booleanOperator) {
            $query .= "WHERE `{$column}` {$operator} ?";
        }

        if ($booleanOperator) {
            $query .= "{$booleanOperator} `{$column}` {$operator} ?";
        }

        if ($endScope) {
            $query .= ')';
        }

        return $query;
    }

    public static function buildConditionManyQuery($column, $operator, $valuesCount, $booleanOperator = null, $startScope = false, $endScope = false)
    {
        $query = ' ';

        if ($startScope) {
            $query .= '(';
        }

        if (!$booleanOperator) {
            $query .= "WHERE `{$column}` {$operator} (";
        }

        if ($booleanOperator) {
            $query .= "{$booleanOperator} `{$column}` {$operator} (";
        }

        for ($i = 1; $i <= $valuesCount; $i++) {
            $query .= '?';

            ($i < $valuesCount) ? $query .= ', ' : $query .= ')';
        }

        if ($endScope) {
            $query .= ')';
        }

        return $query;
    }

    public static function buildSortQuery(array $sorts)
    {
        $query = ' ';

        if (!empty($sorts)) {
            $query .= 'ORDER BY ';
            foreach ($sorts as $key => $order) {
                if ($key > 0) {
                    $query .= ', ';
                }
                $query .= "`{$order[0]}` {$order[1]}";
            }
        }

        return $query;
    }

    public static function buildLimitQuery(int $limit)
    {
        return " LIMIT {$limit}";
    }

    public static function buildOffsetQuery(int $offset)
    {
        return " OFFSET {$offset}";
    }

    public static function buildInsertQuery($table, $keys)
    {
        $query = "INSERT INTO {$table} (`" . implode('`, `', $keys) . '`) VALUES (';

        for ($i = 0; $i < count($keys); $i++) {
            $query .= '?, ';
        }

        $query = rtrim($query, ', ') . ')';

        return $query;
    }

    public static function buildUpdateQuery($table, $keys, $column = null)
    {
        $query = "UPDATE {$table} SET ";

        foreach ($keys as $key) {
            $query .= "{$key} = ?, ";
        }

        $query = rtrim($query, ', ');

        if ($column) {
            $query .= " WHERE {$column} = ?";
        }

        return $query;
    }

    public static function buildDeleteQuery($table, $column = null)
    {
        $query = "DELETE FROM {$table}";

        if ($column) {
            $query .= " WHERE {$column} = ?";
        }

        return $query;
    }
}
