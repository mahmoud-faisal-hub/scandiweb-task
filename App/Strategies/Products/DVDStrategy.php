<?php

namespace App\Strategies\Products;

use App\Strategies\Concerns\ProductStrategyInterface;

class DVDStrategy implements ProductStrategyInterface
{
    public function attributesValidation(): array
    {
        return [
            'size' => 'required|numeric'
        ];
    }

    public function attributesValidationErrorMessages(): array
    {
        return [
            'size.required' => 'required error',
            'size.numeric' => 'numeric error'
        ];
    }

    public function transformAttributes(array $data): array
    {
        return [
            'size' => $data['size']
        ];
    }

    public function formatAttributes(array $data): string
    {
        return 'Size: ' . $data['size'] . ' MB';
    }
}
