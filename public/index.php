<?php

use App\Models\Product;
use Dotenv\Dotenv;
use Mahmoud\ScandiwebTask\Database\Grammars\MySQLGrammar;

require_once __DIR__ . '/../src/Support/helpers.php';
require_once base_path('vendor/autoload.php');
require_once base_path('routes/api.php');

$env = Dotenv::createImmutable(base_path());
$env->load();

app()->run();

// $product = Product::first();

// dump($product);
// dump($product->update([
//     'name' => 'Product 1'
// ]));
$product = Product::first();

$product->name = "Product 1";

dump($product->update());

// $arr = ['username', 'email', 'password', 'full_name'];

// dump(Product::select(['id', 'name'])->where('id', '>', 1)->where('name', 'like', "%2%")->orderBy('name', 'ASC')->first());

// dump(Product::all(['id', 'name']));

// $products = Product::where('name', 'like', "%Pro%")->orderBy('name', 'DESC')->orderBy('id', 'DESC')->limit(1)->offset(1)->get();
// dump($products);



// dump(Product::where('name', '=', 'test')->get());

// dump(MySQLGrammar::buildSelectQuery([
//     'name',
//     'email'
// ], ['name', '=', 'test']));