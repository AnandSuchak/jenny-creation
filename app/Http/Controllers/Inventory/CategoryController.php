<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Inventory\CategoryService;
use App\Http\Requests\Inventory\StoreCategoryRequest;
use App\Http\Requests\Inventory\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * List categories (JSON)
     */
    public function index(): JsonResponse
{
    return response()->json(
        $this->service->list()
    );
}

    /**
     * Store new category
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->create($request->validated());

        return response()->json([
            'message'  => 'Category created successfully',
            'category' => $category,
        ], 201);
    }

    /**
     * Update category
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): JsonResponse {
        $category = $this->service->update($category, $request->validated());

        return response()->json([
            'message'  => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    /**
     * Soft delete category
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->service->delete($category);

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }

    /**
     * Restore soft-deleted category
     */
    public function restore(int $id): JsonResponse
    {
        $category = $this->service->restore($id);

        return response()->json([
            'message'  => 'Category restored successfully',
            'category' => $category,
        ]);
    }

    /**
     * View (Blade)
     */
    public function view()
    {
        return view('inventory.categories.index', [
            'categories' => Category::latest()->get(),
        ]);
    }
}
