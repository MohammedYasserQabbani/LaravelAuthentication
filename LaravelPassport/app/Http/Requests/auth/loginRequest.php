<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages() :array 
    {
        return [
            'email.required' => 'Please enter your email',
            'password.required' => 'Please enter your password',
            'password.min:8' => 'The number of characters must be 8 or more in a field password',
        ];
    }
}
