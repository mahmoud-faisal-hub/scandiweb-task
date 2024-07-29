<?php

namespace App\Validators\Product;

use App\Factories\Products\ProductStrategyFactory;
use Mahmoud\ScandiwebTask\Validation\RequestValidator;

class StoreProductValidator extends RequestValidator
{
    public function rules(): array
    {
        $rules = [
            'sku' => 'required|unique:products,sku',
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'type' => 'required|in:' . implode(',', ProductStrategyFactory::getTypes()),
        ];

        if (request()->has('type') && in_array(request()->get('type'), ProductStrategyFactory::getTypes())) {
            $productStrategy = ProductStrategyFactory::make(request()->get('type'));
            $rules = array_merge($rules, $productStrategy->attributesValidation());
        }

        return $rules;
    }

    public function messages(): array
    {
        return [];
    }
}
