<?php

namespace App\Http\Requests\AdminPanel\Meal;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'price' => ['required', 'int'],
            'category_id' => ['required', 'int'],
            'types' => ['required', 'array'],
            'types*' => ['required', 'int'],
            'description' => ['']
        ];
    }
}