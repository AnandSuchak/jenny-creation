<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Stock;

class InventoryDashboardController extends Controller
{
    public function dashboard()
{
    return view('inventory.dashboard', [
        'stats' => [
            'categories' => \App\Models\Category::count(),
            'products'   => \App\Models\Product::count(),
            'variants'   => \App\Models\ProductVariant::count(),
            'total_stock'=> \App\Models\Stock::sum('quantity'),
        ],

        'stockByLocation' => \App\Models\Stock::with('location')
            ->selectRaw('location_id, SUM(quantity) as total')
            ->groupBy('location_id')
            ->get(),

        'lowStock' => \App\Models\Stock::with(['variant.product', 'location'])
            ->where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->get(),

        'recentMovements' => \App\Models\StockMovement::with([
                'variant.product',
                'location'
            ])
            ->latest()
            ->limit(5)
            ->get(),
    ]);
}

}
