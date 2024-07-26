<?php

namespace App\Strategies\Products;

use App\Strategies\Concerns\ProductStrategyInterface;

class FurnitureStrategy implements ProductStrategyInterface
{
    public function attributesValidation(): array
    {
        return [
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'length' => 'required|numeric'
        ];
    }

    public function attributesValidationErrorMessages(): array
    {
        return [
            'height.required' => 'required error',
            'height.numeric' => 'numeric error',
            'width.required' => 'required error',
            'width.numeric' => 'numeric error',
            'length.required' => 'required error',
            'length.numeric' => 'numeric error',
        ];
    }

    public function transformAttributes(array $data): array
    {
        return [
            'height' => $data['height'],
            'width' => $data['width'],
            'length' => $data['length']
        ];
    }
}
