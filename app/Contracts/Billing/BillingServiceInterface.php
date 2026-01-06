<?php

namespace App\Contracts\Billing;

interface BillingServiceInterface
{
    /**
     * Create a new bill and deduct stock
     */
    public function createBill(array $data);

    /**
     * Cancel bill and restore stock
     */
    public function cancelBill(int $billId): void;

    /**
     * Re-create bill from previous bill
     */
    public function reorder(int $billId);
}
