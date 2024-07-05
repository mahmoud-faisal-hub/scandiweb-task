<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Support\Arr;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class RequiredRule implements Rule
{
    protected $nullable = false;
    public function __construct(bool $nullable = false)
    {
        $this->nullable = $nullable;
    }

	public function apply($field, $value, $data, $rules)
    {
        if (($this->nullable || Arr::containsInstanceOf($rules, NullableRule::class)) && $value === null) {
            return true;
        }

        if (is_null($value)) {
            return false;
        }
        
        if (is_string($value) && trim($value) === '') {
            return false;
        }

        if (is_array($value) && empty($value)) {
            return false;
        }

        if (is_object($value) && method_exists($value, 'isEmpty') && $value->isEmpty()) {
            return false;
        }

        if (is_array($value) || is_object($value)) {
            return true;
        }

        return true;
    }

    public function __toString()
    {
        return '%s field is required.';
    }
}