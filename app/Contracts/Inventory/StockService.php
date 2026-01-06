<?php

namespace App\Services\Inventory;

use App\Contracts\Inventory\StockServiceInterface;

class StockService implements StockServiceInterface
{
    /**
     * Add opening stock for a variant at a location
     */
    public function addOpeningStock(array $data): void
    {
        // TODO: implement opening stock logic
    }

    /**
     * Restock existing stock (purchase)
     */
    public function restock(array $data): void
    {
        // TODO: implement restock logic
    }

    /**
     * Adjust stock manually (admin only)
     */
    public function adjustStock(array $data): void
    {
        // TODO: implement adjustment logic
    }

    /**
     * Deduct stock during billing
     */
    public function deductForBilling(array $data): void
    {
        // TODO: implement billing deduction logic
    }
}
