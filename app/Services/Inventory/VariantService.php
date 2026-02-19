<?php

namespace App\Services\Inventory;

use App\Models\ProductVariant;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class VariantService
{
    /**
     * Create Variant
     */
    public function create(array $data): ProductVariant
    {
        // Auto-generate barcode if not provided
        if (empty($data['barcode'])) {
            $data['barcode'] = $this->generateBarcode();
        }

        return ProductVariant::create($data);
    }

    /**
     * Update Variant
     */
    public function update(ProductVariant $variant, array $data): ProductVariant
    {
        $variant->update($data);

        return $variant;
    }

    /**
     * Soft Delete Variant
     */
    public function delete(ProductVariant $variant): void
    {
        // Optional future rule:
        // Prevent delete if stock exists

        if ($variant->stocks()->exists()) {
            throw ValidationException::withMessages([
                'variant' => 'Cannot delete variant because stock exists.',
            ]);
        }

        $variant->delete();
    }

    /**
     * Restore Soft Deleted Variant
     */
    public function restore(int $id): ProductVariant
    {
        $variant = ProductVariant::withTrashed()->findOrFail($id);

        $variant->restore();

        return $variant;
    }

    /**
     * Generate Unique Barcode
     */
    protected function generateBarcode(): string
    {
        do {
            $barcode = 'VAR' . strtoupper(Str::random(10));
        } while (ProductVariant::where('barcode', $barcode)->exists());

        return $barcode;
    }
}
