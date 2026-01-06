<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\LocationController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\VariantController;
use App\Http\Controllers\Inventory\StockController;

Route::prefix('inventory')->group(function () {

    // CREATE / UPDATE (WRITE)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/locations', [LocationController::class, 'store']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/variants', [VariantController::class, 'store']);

    // STOCK OPERATIONS
    Route::post('/stock/opening', [StockController::class, 'addOpening']);
    Route::post('/stock/restock', [StockController::class, 'restock']);
    Route::post('/stock/adjust', [StockController::class, 'adjust']);

    // READ (JSON)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/stock', [StockController::class, 'index']);
    Route::get('/stock/movements', [StockController::class, 'movements']);

});
