<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\LocationController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\VariantController;
use App\Http\Controllers\Inventory\StockController;

Route::prefix('inventory')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CATEGORY CRUD
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/categories/{category}/restore', [CategoryController::class, 'restore']);

    /*
    |--------------------------------------------------------------------------
    | PRODUCT CRUD
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::post('/products/{product}/restore', [ProductController::class, 'restore']);

    /*
    |--------------------------------------------------------------------------
    | LOCATION
    |--------------------------------------------------------------------------
    */
    Route::post('/locations', [LocationController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | VARIANT (we will expand later)
    |--------------------------------------------------------------------------
    */
    Route::post('/variants', [VariantController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | STOCK
    |--------------------------------------------------------------------------
    */
    Route::post('/stock/opening', [StockController::class, 'addOpening']);
    Route::post('/stock/restock', [StockController::class, 'restock']);
    Route::post('/stock/adjust', [StockController::class, 'adjust']);

    Route::get('/stock', [StockController::class, 'index']);
    Route::get('/stock/movements', [StockController::class, 'movements']);
});
