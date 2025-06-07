<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
      $userId = $this->route('user')?->id;
        return [
              "email" => ["nullable", "email", Rule::unique("users", "email")->ignore($userId)],
              "name" => ["nullable", "min:5", "max:50", "alpha"],
              "username" => ["nullable", "min:5", "max:15", "alpha_num", Rule::unique('users', 'username')->ignore($userId)],
              "phone" => ["nullable", Rule::unique("users", "phone")->ignore($userId)],
              "password" => ["nullable", "alpha_num", "min:8", "max:32", "confirmed"],
              "age" => ["nullable", "numeric", "between:18,64"],
              "roles" => ["nullable", "exists:roles,id"],
              "permissions" => ["nullable", "array"],
              "permissions.*" => ["string","exists:permissions,id"],
        ];
    }
}
