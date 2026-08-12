<?php

namespace App\DTOs\Auth;

class RegisterUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $username,
        public readonly string $phone,
        public readonly string $password,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            email: trim($validated['email']),
            name: trim($validated['name']),
            username: trim($validated['username']),
            phone: $validated['phone'],
            password: $validated['password'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}