<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules;

use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class InRule implements Rule
{
    protected array $haystack;

    public function __construct(...$haystack)
    {
        $this->haystack = $haystack;
    }

    public function apply($field, $value, $data, $rules)
    {
        return in_array($value, $this->haystack);
    }

    public function __toString()
    {
        return '%s field value is invalid.';
    }
}
