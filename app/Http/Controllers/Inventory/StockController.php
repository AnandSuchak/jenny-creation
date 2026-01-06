<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Contracts\Inventory\StockServiceInterface;
use App\Http\Requests\Inventory\AddStockRequest;
use App\Http\Requests\Inventory\AdjustStockRequest;
use App\Models\Stock;
use App\Models\StockMovement;

class StockController extends Controller
{
    public function __construct(
        private StockServiceInterface $stockService
    ) {}

    // Opening stock (once)
    public function addOpening(AddStockRequest $request)
    {
        $this->stockService->addOpeningStock($request->validated());

        return response()->json([
            'message' => 'Opening stock added successfully',
        ]);
    }

    // Restock (increase)
    public function restock(AddStockRequest $request)
    {
        $this->stockService->restock($request->validated());

        return response()->json([
            'message' => 'Stock restocked successfully',
        ]);
    }

    // Adjustment (set quantity)
    public function adjust(AdjustStockRequest $request)
    {
        $this->stockService->adjustStock($request->validated());

        return response()->json([
            'message' => 'Stock adjusted successfully',
        ]);
    }

    public function index()
{
    return response()->json(
        Stock::with(['variant.product', 'location'])->get()
    );
}

public function movements()
{
    return response()->json(
        StockMovement::with(['variant.product', 'location'])
            ->latest()
            ->get()
    );
}

public function view()
{
    return view('inventory.stock', [
        'stocks' => \App\Models\Stock::with(['variant.product', 'location'])->get()
    ]);
}

public function movementsView()
{
    return view('inventory.movements', [
        'movements' => \App\Models\StockMovement::with(['variant.product', 'location'])->latest()->get()
    ]);
}

}
