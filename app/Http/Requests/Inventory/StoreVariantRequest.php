<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'    => 'required|exists:products,id',
            'variant_name'  => 'required|string|max:100',
            'cost_price'    => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0.01',
            'barcode'       => 'required|string|unique:product_variants,barcode',
        ];
    }
}
