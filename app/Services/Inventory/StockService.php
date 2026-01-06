<?php

namespace App\Services\Inventory;

use App\Contracts\Inventory\StockServiceInterface;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockService implements StockServiceInterface
{
    /**
     * Add opening stock (ONLY ONCE per variant + location)
     */
    public function addOpeningStock(array $data): void
    {
        DB::transaction(function () use ($data) {

            // Prevent duplicate opening stock
            $exists = Stock::where('product_variant_id', $data['product_variant_id'])
                ->where('location_id', $data['location_id'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'stock' => 'Opening stock already exists for this variant at this location.',
                ]);
            }

            // Create stock row
            $stock = Stock::create([
                'product_variant_id' => $data['product_variant_id'],
                'location_id'        => $data['location_id'],
                'quantity'           => $data['quantity'],
            ]);

            // Create movement
            StockMovement::create([
                'product_variant_id' => $data['product_variant_id'],
                'location_id'        => $data['location_id'],
                'type'               => 'IN',
                'quantity'           => $data['quantity'],
                'remarks'            => 'Opening stock',
            ]);
        });
    }

    /**
     * Restock existing stock
     */
    public function restock(array $data): void
    {
        DB::transaction(function () use ($data) {

            $stock = Stock::where('product_variant_id', $data['product_variant_id'])
                ->where('location_id', $data['location_id'])
                ->lockForUpdate()
                ->first();

            if (! $stock) {
                throw ValidationException::withMessages([
                    'stock' => 'Stock does not exist. Add opening stock first.',
                ]);
            }

            // Increase quantity
            $stock->increment('quantity', $data['quantity']);

            // Log movement
            StockMovement::create([
                'product_variant_id' => $data['product_variant_id'],
                'location_id'        => $data['location_id'],
                'type'               => 'IN',
                'quantity'           => $data['quantity'],
                'remarks'            => 'Restock',
            ]);
        });
    }

    /**
     * Manual stock adjustment (admin only)
     */
    public function adjustStock(array $data): void
    {
        DB::transaction(function () use ($data) {

            $stock = Stock::where('product_variant_id', $data['product_variant_id'])
                ->where('location_id', $data['location_id'])
                ->lockForUpdate()
                ->first();

            if (! $stock) {
                throw ValidationException::withMessages([
                    'stock' => 'Stock does not exist for adjustment.',
                ]);
            }

            $difference = $data['quantity'] - $stock->quantity;

            if ($difference === 0) {
                return;
            }

            // Update stock
            $stock->update([
                'quantity' => $data['quantity'],
            ]);

            // Log adjustment
            StockMovement::create([
                'product_variant_id' => $data['product_variant_id'],
                'location_id'        => $data['location_id'],
                'type'               => 'ADJUST',
                'quantity'           => abs($difference),
                'remarks'            => 'Manual adjustment',
            ]);
        });
    }

    /**
     * Deduct stock during billing (IMPLEMENT LATER)
     */
    public function deductForBilling(array $data): void
    {
        // Billing phase
    }
}
