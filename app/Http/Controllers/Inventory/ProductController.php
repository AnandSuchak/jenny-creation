<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
        ]);
    }

    public function index()
{
    return response()->json(
        \App\Models\Product::with('variants')
            ->where('is_active', true)
            ->get()
    );
}

public function view()
{
    return view('inventory.products', [
        'products' => \App\Models\Product::with('variants')->get()
    ]);
}


}
