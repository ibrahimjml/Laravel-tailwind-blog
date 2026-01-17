<?php

namespace App\Http\Requests\App;

use App\Models\User;
use App\Rules\EmailProviders;
use App\Rules\PasswordRule;
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
            "email" => ["required", "email", "min:5", "max:50", Rule::unique(User::class),new EmailProviders()],
            "name" => ["required", "min:5", "max:50", "alpha"],
            "username" => ["required", "min:5", "max:15", "alpha_num", Rule::unique(User::class)],
            "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique(User::class)],
            "password" => ["required","confirmed",new PasswordRule()],
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
