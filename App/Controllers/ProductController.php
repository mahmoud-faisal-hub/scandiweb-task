<?php

namespace App\Controllers;

use App\Factories\Products\ProductStrategyFactory;
use App\Models\Product;
use App\Validators\Product\StoreProductValidator;
use Mahmoud\ScandiwebTask\Validation\Validator;

class ProductController
{
    public function index()
    {
        $products = Product::all();

        foreach ($products as &$product) {
            $strategy = ProductStrategyFactory::make($product->type);
            $attributes = json_decode($product->attributes, true);

            $product->attributes = $attributes;
            $product->formated_attributes = $strategy->formatAttributes($attributes);
        }

        return response()->json($products);
    }

    public function store()
    {
        $validator = (new StoreProductValidator())->validate();

        if (!$validator->passes()) {
            abort(422, reset($validator->errors())[0], $validator->errors());
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

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404, "This product doesn't exist");
        }

        $product->delete();

        abort(200, 'Deleted');
    }

    public function bulkDelete()
    {
        $validator = new Validator();

        $validator->setRules([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:products,id'
        ]);

        $validator->make(request()->all());

        if (!$validator->passes()) {
            abort(422, reset($validator->errors())[0], $validator->errors());
        }

        Product::whereIn('id', request()->get('ids'))->delete();

        abort(200, 'Deleted');
    }
}
