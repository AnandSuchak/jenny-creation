<?php

namespace App\Providers;

use App\Contracts\Inventory\StockServiceInterface;
use Illuminate\Support\ServiceProvider;

// Inventory contracts

// Inventory services
use App\Services\Inventory\StockService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind inventory stock service
        $this->app->bind(
            StockServiceInterface::class,
            StockService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
