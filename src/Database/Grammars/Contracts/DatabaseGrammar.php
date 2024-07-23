<?php

namespace Mahmoud\ScandiwebTask\Database\Grammars\Contracts;

use PDO;

interface DatabaseGrammar
{
    public static function buildSelectQuery($columns = "*", $table, $filters = null);

    public static function buildConditionQuery($column, $operator, $booleanOperator = null, $startScope = false, $endScope = false);

    public static function buildConditionManyQuery($column, $operator, $valuesCount, $booleanOperator = null, $startScope = false, $endScope = false);

    public static function buildSortQuery(array $sorts);

    public static function buildLimitQuery(int $limit);

    public static function buildOffsetQuery(int $offset);

    public static function buildInsertQuery($table, $keys);

    public static function buildUpdateQuery($table, $keys, $column = null);

    public static function buildDeleteQuery($table, $column = null);
}
