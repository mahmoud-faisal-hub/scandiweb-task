<?php

namespace Mahmoud\ScandiwebTask\Validation;

use Mahmoud\ScandiwebTask\Validation\Rules\AlphaNumericalRule;
use Mahmoud\ScandiwebTask\Validation\Rules\BetweenRule;
use Mahmoud\ScandiwebTask\Validation\Rules\ExistsRule;
use Mahmoud\ScandiwebTask\Validation\Rules\FloatRule;
use Mahmoud\ScandiwebTask\Validation\Rules\InRule;
use Mahmoud\ScandiwebTask\Validation\Rules\IntegerRule;
use Mahmoud\ScandiwebTask\Validation\Rules\MaxRule;
use Mahmoud\ScandiwebTask\Validation\Rules\MinRule;
use Mahmoud\ScandiwebTask\Validation\Rules\NullableRule;
use Mahmoud\ScandiwebTask\Validation\Rules\NumericRule;
use Mahmoud\ScandiwebTask\Validation\Rules\RequiredRule;
use Mahmoud\ScandiwebTask\Validation\Rules\StringRule;
use Mahmoud\ScandiwebTask\Validation\Rules\UniqueRule;

trait RulesMapper
{
    protected static array $ruleMap = [
        'nullable' => NullableRule::class,
        'required' => RequiredRule::class,
        'alnum' => AlphaNumericalRule::class,
        'max' => MaxRule::class,
        'min' => MinRule::class,
        'between' => BetweenRule::class,
        'string' => StringRule::class,
        'numeric' => NumericRule::class,
        'integer' => IntegerRule::class,
        'float' => FloatRule::class,
        'in' => InRule::class,
        'unique' => UniqueRule::class,
        'exists' => ExistsRule::class,
    ];

    public static function resolve(string $rule, $params)
    {
        return new static::$ruleMap[$rule](...$params);
    }

    public static function getRuleName($object)
    {
        foreach (static::$ruleMap as $ruleName => $ruleClass) {
            if ($object instanceof $ruleClass) {
                return $ruleName;
            }
        }

        return null;
    }
}
