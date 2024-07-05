<?php

namespace Mahmoud\ScandiwebTask\Validation;

use Mahmoud\ScandiwebTask\Validation\Rules\Contract\Rule;

class Validator
{
	protected array $data = [];

    protected array $aliases = [];

	protected array $rules = [];

	protected array $errorMessages = [];

	protected ErrorBag $errorBag;

    public function make($data)
    {
        $this->data = $data;
        $this->errorBag = new ErrorBag();
        $this->validate();
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function passes()
    {
        return empty($this->errors());
    }

    public function errors($key = null)
    {
        return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
    }

    public function setErrorMessages(array $errorMessages): array
    {
        return $this->errorMessages = $errorMessages;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    protected function validate()
    {
        foreach ($this->rules as $field => $rules) {
            if ($this->isWildcardField($field)) {
                $this->validateWildcardField($field, $rules);
            } else {
                $this->validateField($field, $rules, $field);
            }
        }
    }

    private function isWildcardField($field)
    {
        return strpos($field, '.*') !== false;
    }

    private function validateWildcardField($field, $rules)
    {
        $fieldName = explode('.*', $field)[0];
        if (!isset($this->data[$fieldName]) || !is_array($this->data[$fieldName])) {
            return;
        }
        
        foreach ($this->data[$fieldName] as $index => $item) {
            $this->validateField("$fieldName.$index", $rules, $field);
        }
    }

    private function validateField($field, $rules, $filedKey)
    {
        foreach (RulesResolver::make($rules) as $rule) {
            $this->applyRule($field, $rule, RulesResolver::make($rules), $filedKey);
        }
    }

    protected function applyRule($field, Rule $rule, $roles, $filedKey)
    {
        [$resolvedField, $value] = FieldResolver::resolve($field, $this->data);
        if (!$rule->apply($resolvedField, $value, $this->data, $roles)) {
            $message = $this->errorMessages[$filedKey . '.' . RulesMapper::getRuleName($rule)];
            
            $this->errorBag->add($field, Message::generate($message?? $rule, $this->alias($field)));
        } 
    }
}