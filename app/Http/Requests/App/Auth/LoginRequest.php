<?php

namespace App\Http\Requests\App\Auth;

use App\DTOs\Auth\LoginUserDTO;
use App\Rules\UsernameOrEmail;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string', new UsernameOrEmail()],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }

    public function toDTO(): LoginUserDTO
    {
        return LoginUserDTO::fromRequest($this->validated());
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $dto = $this->toDTO();

            if (! auth()->validate($dto->credentials())) {
                $validator->errors()->add('login','Wrong credentials.');
            }
        });
    }
}