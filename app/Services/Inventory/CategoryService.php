<?php

namespace App\Services\Inventory;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    /**
     * Create category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update category
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * Soft delete category
     *
     * Rule: Cannot delete if products exist
     */
    public function delete(Category $category): void
    {
        if ($category->products()->exists()) {
            throw ValidationException::withMessages([
                'category' => 'Cannot delete category because products exist.',
            ]);
        }

        $category->delete();
    }

    /**
     * Restore soft deleted category
     */
    public function restore(int $categoryId): Category
    {
        $category = Category::withTrashed()->findOrFail($categoryId);

        $category->restore();

        return $category;
    }
    public function list()
    {
    return Category::latest()->get();
    }

}
