<?php

namespace Mahmoud\ScandiwebTask\Validation\Rules\Contract;

interface Rule
{
	public function apply($field, $value, $data, $rules);

    public function __toString();
}