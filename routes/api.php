<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderApiController; // <-- add this

Route::get('/products', fn () =>
    Product::with('category')->paginate(20)
);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn (Request $request) => $request->user());
    Route::post('/orders', [OrderApiController::class, 'store']);
});
