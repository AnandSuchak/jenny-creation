<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:100|unique:categories,name',
            'slug'       => 'required|string|max:120|unique:categories,slug',
            'filter_tag' => 'nullable|string|max:50',
        ];
    }
}
