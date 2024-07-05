<?php

namespace Mahmoud\ScandiwebTask\Validation;

class Message
{
	public static function generate($rule, $field)
    {
        return str_replace('%s', $field, $rule);
    }
}