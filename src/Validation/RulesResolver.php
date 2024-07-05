<?php

namespace Mahmoud\ScandiwebTask\Validation;

trait RulesResolver
{
	public static function make($rules)
    {
        $rules = is_string($rules)? explode('|', $rules) : $rules;

        return array_map(function ($rule) {
            if (is_string($rule)) {
                return static::getRuleFromString($rule);
            }

            return $rule;
        }, $rules);
    }

    public static function getRuleFromString(string $rule)
    {
        [$ruleName, $ruleParams] = explode(':', $rule) + [1 => ''];
        $ruleParams = $ruleParams !== '' ? explode(',', $ruleParams) : [];

        return RulesMapper::resolve($ruleName, $ruleParams);
    }
}