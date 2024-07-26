<?php

namespace App\Strategies\Products;

use App\Strategies\Concerns\ProductStrategyInterface;

class BookStrategy implements ProductStrategyInterface
{
    public function attributesValidation(): array
    {
        return [
            'weight' => 'required|numeric'
        ];
    }

    public function attributesValidationErrorMessages(): array
    {
        return [
            'weight.required' => 'required error',
            'weight.numeric' => 'numeric error'
        ];
    }

    public function transformAttributes(array $data): array
    {
        return [
            'weight' => $data['weight']
        ];
    }
}
