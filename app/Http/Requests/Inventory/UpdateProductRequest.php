<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')
    ->ignore($this->route('product')->id)
    ->whereNotNull('slug'),
            ],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

   protected function prepareForValidation(): void
{
    $this->merge([
        'slug' => $this->slug ? strtolower(trim($this->slug)) : null,
    ]);
}

}
