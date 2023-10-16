<?php

namespace App\Http\Requests\AdminPanel\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => ['required', 'max:255'],
            "surname" => ['required', 'max:255'],
            "email" => ['required', 'email', 'max:255', 'unique:users'],
            "password" => ['confirmed', 'min:8', 'max:255'],
            "role_id" => ['required'],
            "photoPath" => [''],
        ];
    }
}
