<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class FloatRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }

    public function __toString()
    {
        return '%s field value must be float.';
    }
}