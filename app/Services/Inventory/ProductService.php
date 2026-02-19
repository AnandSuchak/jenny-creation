<?php

namespace App\Services\Inventory;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create Product
     */
    public function create(array $data): Product
    {
        // Auto generate SKU
        $data['sku'] = $this->generateSku();

        return Product::create($data);
    }

    /**
     * Update Product
     */
    public function update(Product $product, array $data): Product
    {
        // Never allow SKU change
        unset($data['sku']);

        $product->update($data);

        return $product;
    }

    /**
     * Soft Delete Product
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }

    /**
     * Restore Soft Deleted Product
     */
    public function restore(int $productId): Product
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $product->restore();

        return $product;
    }

    /**
     * Generate Unique SKU
     */
    private function generateSku(): string
    {
        $prefix = 'JEN';

        $lastProduct = Product::withTrashed()
            ->orderByDesc('id')
            ->first();

        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;

        return $prefix . '-PROD-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}
