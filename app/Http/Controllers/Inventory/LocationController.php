<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function store(StoreLocationRequest $request)
    {
        Location::create($request->validated());

        return response()->json([
            'message' => 'Location created successfully',
        ]);
    }
}
