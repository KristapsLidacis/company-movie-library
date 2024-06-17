<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    // Handles the validation rules for logging in a user.

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
        // Define the validation rules for the request data
        return [
            'email' => 'required|string|email', // Email must be a required string with email type
            'password' => 'required|string|min:8', // Password must be a required string with minimal length of 8 characters
        ];
    }
}