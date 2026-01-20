<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Authorization logic
     */
    public function authorize(): bool
    {
        return true; // auth later
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'slug'       => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'filter_tag' => ['nullable', 'string', 'max:100'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    /**
     * Clean validated data
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('slug')) {
            $this->merge([
                'slug' => strtolower(trim($this->slug)),
            ]);
        }
    }
}
