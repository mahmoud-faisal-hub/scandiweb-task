<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class AlphaNumericalRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $value);
    }

    public function __toString()
    {
        return '%s field must contain characters and numbers only.';
    }
}