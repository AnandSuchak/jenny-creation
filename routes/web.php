<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\InventoryDashboardController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\StockController;

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
| Opening "/" should land on Inventory Dashboard
*/

Route::get('/', function () {
    return redirect()->route('inventory.dashboard');
});

/*
|--------------------------------------------------------------------------
| Inventory Web Views (Blade)
|--------------------------------------------------------------------------
| URL prefix: /inventory/*
*/

Route::prefix('inventory')->name('inventory.')->group(function () {

    // DASHBOARD
    Route::get('/', [InventoryDashboardController::class, 'dashboard'])
        ->name('dashboard');

    // VIEWS
    Route::get('/categories', [CategoryController::class, 'view'])
        ->name('categories');

    Route::get('/products', [ProductController::class, 'view'])
        ->name('products');

    Route::get('/stock', [StockController::class, 'view'])
        ->name('stock');

    Route::get('/movements', [StockController::class, 'movementsView'])
        ->name('movements');
});
