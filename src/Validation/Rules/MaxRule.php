<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Support\Arr;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class MaxRule implements Rule
{
    protected int $max;
    protected $value;
    protected $rules;

    public function __construct(int $max)
    {
        $this->max = $max;
    }

	public function apply($field, $value, $data, $rules)
    {
        $this->value = $value;
        $this->rules = $rules;

        if (is_numeric($value) && !Arr::containsInstanceOf($rules, StringRule::class)) {
            return $value <= $this->max;
        }

        return strlen($value) <= $this->max;
    }

    public function __toString()
    {
        if (is_numeric($this->value) && !Arr::containsInstanceOf($this->rules, StringRule::class)) {
            return "%s field can't be greater than {$this->max}.";
        }

        return "%s field length can't be more than {$this->max} characters.";
    }
}