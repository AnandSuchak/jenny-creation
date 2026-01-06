<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category,
        ]);
    }


    public function index()
{
    return response()->json(
        \App\Models\Category::where('is_active', true)->get()
    );
}

public function view()
{
    return view('inventory.categories', [
        'categories' => \App\Models\Category::all()
    ]);
}


}
