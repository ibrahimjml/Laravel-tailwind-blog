<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
             "email" => ["required", "email", "min:5", "max:50", Rule::unique("users", "email")],
            "name" => ["required", "min:5", "max:50", "alpha"],
            "username" => ["required", "min:5", "max:15", "alpha_num", Rule::unique('users','username')],
            "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique("users", "phone")],
            "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
            "age" => ["required", "integer", "between:18,64"]
        ];
    }
     public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number must include a valid country code.'
        ];
    }
}
