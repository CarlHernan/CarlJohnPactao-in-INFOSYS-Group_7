<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\ProductController;

//api goes here, separate ang api at FE endpoints for cleanliness.
Route::prefix('admin')->group(function () {
    Route::apiResource('menu', ProductController::class)->parameters(['menu' => 'product']);

        /*since gi query nato, uselss sya, for good practices lang*/
    Route::get('menu/featured', [ProductController::class, 'featured']);
});
