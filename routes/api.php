<?php

use App\Controllers\ProductController;
use Mahmoud\ScandiwebTask\Http\Route;

Route::get("/", function () {
    echo "Home Page";
});

Route::get("/products", [ProductController::class, "index"]);

Route::post("/products", [ProductController::class, "store"]);

Route::delete("/products/bulk", [ProductController::class, "bulkDelete"]);

Route::delete("/products/{id}", [ProductController::class, "delete"]);
