<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Database\QueryBuilder;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class ExistsRule implements Rule
{
    protected string $table;
    protected string $column;

    public function __construct(string $table, string $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function apply($field, $value, $data, $rules)
    {
        $query = (new QueryBuilder())->table($this->table);

        return $query->where($this->column, '=', $value)->first();
    }

    public function __toString()
    {
        return "%s doesn't exist.";
    }
}
