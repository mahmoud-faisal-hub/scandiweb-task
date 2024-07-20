<?php

namespace Mahmoud\ScandiwebTask\Database;

class QueryBuilder
{
    protected $grammar;
    protected $model;
    protected $table;
    protected $columns = "*";
    protected $query;
    protected $limit;
    protected $offset;

    public function __construct()
    {
        $this->grammar = app()->db->grammar();
        $this->query = [];
    }

    public function table($tableName)
    {
        $this->table = $tableName;
        return $this;
    }
    public function model($model)
    {
        $this->model = $model;
        $this->table = $model::getTableName();
        return $this;
    }

    public function select($columns = "*")
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $this->columns = $columns;

        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->query[] = [
            'type' => 'where',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function whereIn($column, array $values)
    {
        $this->query[] = [
            'type' => 'whereIn',
            'column' => $column,
            'operator' => 'in',
            'values' => $values
        ];
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->query[] = [
            'type' => 'orderBy',
            'column' => $column,
            'direction' => $direction
        ];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    protected function build(array $types = [
        'filter' => false,
        'sort' => false,
        'limit' => false,
        'offset' => false,
    ])
    {
        $filters = [];
        $params = [];
        $orderBy = [];

        foreach ($this->query as $item) {
            switch ($item['type']) {
                case 'where':
                    if ($types['filter']) {
                        $filters[] = [$item['column'], $item['operator'], $item['value']];
                        $params[] = $item['value'];
                    }

                    break;
                case 'whereIn':
                    if ($types['filter']) {
                        $filters[] = [$item['column'], $item['operator'], $item['values']];
                        foreach ($item['values'] as $value) {
                            $params[] = $value;
                        }
                    }

                    break;
                case 'orderBy':
                    if ($types['sort']) {
                        $orderBy[] = [$item['column'], $item['direction']];
                    }

                    break;
            }
        }

        $query = '';

        if (!empty($filters) && $types['filter']) {
            foreach ($filters as $key => $filter) {
                if ($key == 0) {
                    if (is_array($filter[2])) {
                        $query .= $this->grammar::buildConditionManyQuery($filter[0], $filter[1], count($filter[2]));
                    } else {
                        $query .= $this->grammar::buildConditionQuery($filter[0], $filter[1]);
                    }

                    continue;
                }

                if (is_array($filter[2])) {
                    $query .= $this->grammar::buildConditionManyQuery($filter[0], $filter[1], count($filter[2]), 'AND');
                } else {
                    $query .= $this->grammar::buildConditionQuery($filter[0], $filter[1], 'AND');
                }
            }
        }

        if (!empty($orderBy) && $types['sort']) {
            $query .= $this->grammar::buildSortQuery($orderBy);
        }

        if ($this->limit && $types['limit']) {
            $query .= $this->grammar::buildLimitQuery($this->limit);
        }

        if ($this->offset && $types['offset']) {
            $query .= $this->grammar::buildOffsetQuery($this->offset);
        }

        return [
            'query' => $query,
            'params' => $params
        ];
    }

    public function get()
    {
        $query = $this->grammar::buildSelectQuery($this->columns, $this->table);

        $build = $this->build([
            'filter' => true,
            'sort' => true,
            'limit' => true,
            'offset' => true,
        ]);

        $query .= $build['query'];

        return app()->db->raw($query, $build['params'], true, $this->model);
    }

    public function first()
    {
        return $this->limit(1)->get()[0] ?? [];
    }

    public function update(array $attributes)
    {
        $query = $this->grammar::buildUpdateQuery($this->table, array_keys($attributes));

        $build = $this->build([
            'filter' => true,
        ]);

        $query .= $build['query'];

        $updated = app()->db->raw($query, array_merge(array_values($attributes), $build['params']), false);

        if ($updated) {
            return $this->get();
        }

        return false;
    }

    public function delete()
    {
        $query = $this->grammar::buildDeleteQuery($this->table);

        $build = $this->build([
            'filter' => true,
        ]);

        $query .= $build['query'];

        return app()->db->raw($query, $build['params'], false);
    }
}
