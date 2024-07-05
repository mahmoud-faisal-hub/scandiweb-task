<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class IntegerRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    public function __toString()
    {
        return '%s field value must be integer.';
    }
}