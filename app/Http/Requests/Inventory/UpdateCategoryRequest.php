<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

        public function rules(): array
        {
            return [
                'name' => ['required', 'string', 'max:255'],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories', 'slug')->ignore(
                        $this->route('category')->id
                    ),
                ],
                'filter_tag' => ['nullable', 'string', 'max:100'],
                'is_active'  => ['nullable', 'boolean'],
            ];
        }


    protected function prepareForValidation(): void
    {
        if ($this->has('slug')) {
            $this->merge([
                'slug' => strtolower(trim($this->slug)),
            ]);
        }
    }
}
