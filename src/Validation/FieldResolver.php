<?php

namespace Mahmoud\ScandiwebTask\Validation;

trait FieldResolver
{
	public static function resolve(string $field, array $data): array
    {
        if (strpos($field, '.') !== false) {
            return static::resolveNestedField($field, $data);
        }

        return [$field, $data[$field] ?? null];
    }

    private static function resolveNestedField(string $field, array $data): array
    {
        $parts = explode('.', $field);
        $baseField = array_shift($parts);
        $value = $data[$baseField] ?? null;

        foreach ($parts as $part) {
            if (!is_array($value) || !isset($value[$part])) {
                return [$field, null];
            }
            $value = $value[$part];
        }

        return [$field, $value];
    }
}