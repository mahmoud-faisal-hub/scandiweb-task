<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Support\Arr;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class BetweenRule implements Rule
{
	protected int $min;
	protected int $max;
    protected $value;
    protected $rules;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

	public function apply($field, $value, $data, $rules)
    {
        $this->value = $value;
        $this->rules = $rules;

        if (is_numeric($value) && !Arr::containsInstanceOf($rules, StringRule::class)) {
            return $value >= $this->min && $value <= $this->max;
        }

        return strlen($value) >= $this->min && strlen($value) <= $this->max;
    }

    public function __toString()
    {
        if (is_numeric($this->value) && !Arr::containsInstanceOf($this->rules, StringRule::class)) {
            return "%s field value Must be between {$this->min}, {$this->max}.";
        }

        return "%s field length Must be between {$this->min}, {$this->max} characters.";
    }
}