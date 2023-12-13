<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field must be required',
            'email.required' => 'Email field must be required',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'Password field must be required',
            'password.min' => 'Password must be 6 characters',

        ];
    }
}
