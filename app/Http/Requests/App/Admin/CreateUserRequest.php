<?php

namespace App\Http\Requests\App\Admin;

use App\Models\User;
use App\Rules\EmailProviders;
use App\Rules\PasswordRule;
use App\Rules\Username;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
              "email" => ["required", "email", Rule::unique(User::class),new EmailProviders()],
              "name" => ["required", "min:5", "max:50", "alpha"],
              "username" => ["required", "min:5", "max:15", "alpha_num", Rule::unique(User::class),new Username],
              "phone" => ["required", Rule::unique(User::class)],
              "password" => ["required", "confirmed",new PasswordRule()],
              "age" => ["required", "numeric", "between:18,64"],
              "roles" => ["required", "exists:roles,id"],
              "permissions" => ["nullable", "array"],
              "permissions.*" => ["string","exists:permissions,id"],
        ];
    }
}
