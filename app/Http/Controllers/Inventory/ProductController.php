<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreProductRequest;
use App\Http\Requests\Inventory\UpdateProductRequest;
use App\Models\Product;
use App\Services\Inventory\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * List Products
     */
    public function index(): JsonResponse
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return response()->json($products);
    }

    /**
     * Store Product
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }


            /**
         * Show Products Blade View
         */
        public function view()
        {
            return view('inventory.products.index');
        }

    /**
     * Update Product
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $updated = $this->service->update($product, $request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $updated
        ]);
    }

    /**
     * Soft Delete Product
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->service->delete($product);

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Restore Soft Deleted Product
     */
    public function restore(int $id): JsonResponse
    {
        $product = $this->service->restore($id);

        return response()->json([
            'message' => 'Product restored successfully',
            'product' => $product
        ]);
    }
}
