<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreVariantRequest;
use App\Http\Requests\Inventory\UpdateVariantRequest;
use App\Models\ProductVariant;
use App\Services\Inventory\VariantService;
use Illuminate\Http\JsonResponse;

class VariantController extends Controller
{
    protected VariantService $service;

    public function __construct(VariantService $service)
    {
        $this->service = $service;
    }

    /**
     * List Variants (optional filter by product)
     */
    public function index(): JsonResponse
    {
        $query = ProductVariant::with('product')->latest();

        if (request()->has('product_id')) {
            $query->where('product_id', request('product_id'));
        }

        $variants = $query->get();

        return response()->json($variants);
    }

    /**
     * Store Variant
     */
    public function store(StoreVariantRequest $request): JsonResponse
    {
        $variant = $this->service->create($request->validated());

        return response()->json([
            'message' => 'Variant created successfully',
            'variant' => $variant,
        ]);
    }

    /**
     * Update Variant
     */
    public function update(UpdateVariantRequest $request, ProductVariant $variant): JsonResponse
    {
        $updated = $this->service->update($variant, $request->validated());

        return response()->json([
            'message' => 'Variant updated successfully',
            'variant' => $updated,
        ]);
    }

    /**
     * Soft Delete Variant
     */
    public function destroy(ProductVariant $variant): JsonResponse
    {
        $this->service->delete($variant);

        return response()->json([
            'message' => 'Variant deleted successfully',
        ]);
    }

    /**
     * Restore Variant
     */
    public function restore(int $id): JsonResponse
    {
        $variant = $this->service->restore($id);

        return response()->json([
            'message' => 'Variant restored successfully',
            'variant' => $variant,
        ]);
    }
}
