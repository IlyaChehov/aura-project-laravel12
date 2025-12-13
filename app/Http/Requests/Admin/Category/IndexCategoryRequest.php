<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class IndexCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter.id' => 'nullable|string',
            'filter.title' => 'nullable|string',
            'filter.slug' => 'nullable|string',
            'pagination.per_page' => 'required|integer',
            'pagination.page' => 'required|integer',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'pagination' => [
                'per_page' => (int) ($this['pagination.per_page'] ?? 3),
                'page' => (int) ($this['pagination.page'] ?? 1),
            ]
        ]);
    }
}
