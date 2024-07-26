<?php

namespace App\Strategies\Concerns;

interface ProductStrategyInterface
{
    public function attributesValidation(): array;
    public function attributesValidationErrorMessages(): array;
    public function transformAttributes(array $data): array;
}
