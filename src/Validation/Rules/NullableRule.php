<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;
use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class NullableRule implements Rule
{
	public function apply($field, $value, $data, $rules)
    {
        return true;
    }

    public function __toString()
    {
        return "%s field can be null.";
    }
}