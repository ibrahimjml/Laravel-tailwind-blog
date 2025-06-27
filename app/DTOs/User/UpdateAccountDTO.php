<?php

namespace App\DTOs\User;

use App\Http\Requests\App\UpdateAccountRequest;

class UpdateAccountDTO
{
    public function __construct(
      public readonly ?string $username,
      public readonly ?string $email,
      public readonly ?string $currentpassword,
      public readonly ?string $password = null,
    ){}

      public static function fromRequest(UpdateAccountRequest $request): self
      {
        return new self(
          username:$request->input('username'),
          email:$request->input('email'),
          currentpassword:$request->input('current_password'),
          password:$request->input('password')
        );
      }
}
