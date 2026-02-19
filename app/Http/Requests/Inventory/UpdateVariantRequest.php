<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'    => ['required', 'exists:products,id'],
            'variant_name'  => ['required', 'string', 'max:255'],
            'cost_price'    => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'barcode'       => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product_variants', 'barcode')
                    ->ignore($this->route('variant'))
            ],
            'is_active'     => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'variant_name' => trim($this->variant_name),
            'cost_price' => $this->cost_price ?? 0,
            'is_active' => $this->is_active ?? 1,
        ]);
    }
}
