<?php

namespace Mahmoud\ScandiwebTask\Validation;

abstract class RequestValidator
{
    abstract public function rules(): array;

    abstract public function messages(): array;

    public function aliasses(): array
    {
        return [];
    }

    public function validate(): Validator
    {
        $validator = new Validator();

        $validator->setRules($this->rules());
        $validator->setAliases($this->aliasses());
        $validator->setErrorMessages($this->messages());

        $validator->make(request()->all());

        return $validator;
    }
}
