<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class StringRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return is_string($value);
    }

    public function __toString()
    {
        return '%s field must be string.';
    }
}