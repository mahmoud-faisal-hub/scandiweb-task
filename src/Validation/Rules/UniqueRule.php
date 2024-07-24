<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Database\QueryBuilder;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class UniqueRule implements Rule
{
    protected string $table;
    protected string $column;
    protected $ignore = null;
    protected string $ignore_column = 'id';

    public function __construct(string $table, string $column, $ignore = null, string $ignore_column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignore = $ignore;
        $this->ignore_column = $ignore_column;
    }

    public function apply($field, $value, $data, $rules)
    {
        $query = (new QueryBuilder())->table($this->table);

        if ($this->ignore) {
            return !$query->where($this->column, '=', $value)->where($this->ignore_column, '<>', $this->ignore)->first();
        }

        return !$query->where($this->column, '=', $value)->first();
    }

    public function __toString()
    {
        return "%s already exist.";
    }
}
