<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\RegisterUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
     public function execute(RegisterUserDTO $dto): User
    {
         return User::create([
               ...$dto->toArray(),
               'password' => Hash::make($dto->password),
             ]);
    }
}
