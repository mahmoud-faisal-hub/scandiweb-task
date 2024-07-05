<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class NumericRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return is_numeric($value);
    }

    public function __toString()
    {
        return '%s field value must be numeric.';
    }
}