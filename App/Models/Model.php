<?php

namespace App\Models;

use Mahmoud\ScandiwebTask\Database\QueryBuilder;
use Mahmoud\ScandiwebTask\Support\Str;

abstract class Model
{
    protected static $tableName;
    protected static $fillable = [];
	protected static $primary = 'id';
	protected static $instance;
    protected $query = [];
    protected $params = [];

    protected static function query()
    {
        self::$instance = static::class;
        
        return (new QueryBuilder())->model(static::getModel());
    }

    public static function select($columns)
    {
        return static::query()->select($columns);
    }

    public static function where($column, $operator, $value)
    {
        return static::query()->where($column, $operator, $value);
    }

    public static function whereIn($column, array $values)
    {
        return static::query()->whereIn($column, $values);
    }

    public static function orderBy($column, $direction = 'ASC')
    {
        return static::query()->orderBy($column, $direction);
    }

    public static function limit(int $limit)
    {
        return static::query()->limit($limit);
    }

    public static function offset($offset)
    {
        return static::query()->offset($offset);
    }

    public static function get()
    {
        return static::query()->get();
    }

    public static function first()
    {
        return static::query()->first();
    }

    public static function find($value, $column = null)
    {
        $column ??= self::$primary;

        return static::query()->where($column, '=', $value)->first();
    }

    public static function all($columns = '*')
    {
        self::$instance = static::class;

        return app()->db->read($columns, static::getTableName());
    }

    public static function create(array $attributes)
    {
        self::$instance = static::class;

        return app()->db->create(static::getTableName(), $attributes);
    }

    public function update(array $attributes = null)
    {
        self::$instance = static::class;
        
        if (!$attributes) {
            foreach (static::$fillable as $key) {
                if (property_exists($this, $key)) {
                    $attributes[$key] = $this->$key;
                }
            }
        }
        
        $updated = app()->db->update(static::getTableName(), $attributes, self::$primary, $this->{self::$primary});

        if ($updated) {
            return $this->find($this->{self::$primary});
        }

        return false;
    }

    public function delete()
    {
        self::$instance = static::class;

        return app()->db->delete(static::getTableName(), self::$primary, $this->{self::$primary});
    }

    public static function getModel()
    {
        return self::$instance;
    }

    public static function getTableName()
    {
        if (static::$tableName) {
            return static::$tableName;
        }
        
        return Str::lower(Str::plural(class_basename(self::$instance)));
    }
}