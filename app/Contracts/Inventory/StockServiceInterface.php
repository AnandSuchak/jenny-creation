<?php

namespace App\Contracts\Inventory;

interface StockServiceInterface
{
    /**
     * Add opening stock for a variant at a location
     */
    public function addOpeningStock(array $data): void;

    /**
     * Add stock for existing variant/location (purchase / restock)
     */
    public function restock(array $data): void;

    /**
     * Adjust stock manually (admin only)
     */
    public function adjustStock(array $data): void;

    /**
     * Deduct stock during billing
     */
    public function deductForBilling(array $data): void;
}
