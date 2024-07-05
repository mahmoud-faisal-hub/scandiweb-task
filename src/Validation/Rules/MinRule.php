<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Support\Arr;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class MinRule implements Rule
{
    protected int $min;
    protected $value;
    protected $rules;

    public function __construct(int $min)
    {
        $this->min = $min;
    }

	public function apply($field, $value, $data, $rules)
    {
        $this->value = $value;
        $this->rules = $rules;

        if (is_numeric($value) && !Arr::containsInstanceOf($rules, StringRule::class)) {
            return $value >= $this->min;
        }

        return strlen($value) >= $this->min;
    }

    public function __toString()
    {
        if (is_numeric($this->value) && !Arr::containsInstanceOf($this->rules, StringRule::class)) {
            return "%s field can't be less than {$this->min}.";
        }

        return "%s field length can't be less than {$this->min} characters.";
    }
}