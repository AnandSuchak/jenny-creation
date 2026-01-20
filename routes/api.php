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

    // READ
    Route::get('/categories', [CategoryController::class, 'index']);

    // CREATE
    Route::post('/categories', [CategoryController::class, 'store']);

    // UPDATE
    Route::put('/categories/{category}', [CategoryController::class, 'update']);

    // DELETE (soft delete)
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    // RESTORE (soft deleted)
    Route::post('/categories/{id}/restore', [CategoryController::class, 'restore']);

    Route::post('/locations', [LocationController::class, 'store']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/variants', [VariantController::class, 'store']);

    Route::post('/stock/opening', [StockController::class, 'addOpening']);
    Route::post('/stock/restock', [StockController::class, 'restock']);
    Route::post('/stock/adjust', [StockController::class, 'adjust']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/stock', [StockController::class, 'index']);
    Route::get('/stock/movements', [StockController::class, 'movements']);

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/categories/{category}/restore', [CategoryController::class, 'restore']);

});
