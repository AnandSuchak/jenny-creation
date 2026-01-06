<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreVariantRequest;
use App\Models\ProductVariant;

class VariantController extends Controller
{
    public function store(StoreVariantRequest $request)
    {
        ProductVariant::create($request->validated());

        return response()->json([
            'message' => 'Variant created successfully',
        ]);
    }
}
