<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class ArrayRule implements Rule
{
    public function apply($field, $value, $data, $rules)
    {
        return is_array($value);
    }

    public function __toString()
    {
        return '%s must be an array.';
    }
}
