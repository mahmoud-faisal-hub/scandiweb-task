<?php

namespace App\Controllers;

use App\Factories\Products\ProductStrategyFactory;
use App\Models\Product;
use App\Validators\Product\StoreProductValidator;

class ProductController
{
    public function index()
    {
        $products = Product::all();

        foreach ($products as &$product) {
            $product->attributes = json_decode($product->attributes);
        }

        return response()->json($products);
    }

    public function store()
    {
        $validator = (new StoreProductValidator())->validate();

        if (!$validator->passes()) {
            return response()->json($validator->errors());
        }

        $productStrategy = ProductStrategyFactory::make(request()->get('type'));

        Product::create([
            'sku' => request()->get('sku'),
            'name' => request()->get('name'),
            'price' => request()->get('price'),
            'type' => request()->get('type'),
            'attributes' => json_encode($productStrategy->transformAttributes(request()->all())),
        ]);

        abort(201, 'Created');
    }
}
