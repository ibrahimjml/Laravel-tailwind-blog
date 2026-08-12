<?php

namespace App\Services\Auth;

use App\DTOs\Auth\LoginUserDTO;
use App\Enums\Auth\LoginResults;
use App\Exceptions\Auth\LoginException;
use App\Models\User;

class LoginUserService
{
    public function handleLogin(LoginUserDTO $dto): LoginResults
    {
        if (! auth()->validate($dto->credentials())) {
            throw LoginException::invalidCredentials();
        }

        $user = $this->findUser($dto);

        $this->validateUser($user);

        if ($user->has_two_factor_enabled) {
            $this->prepareTwoFactor($user, $dto->remember);

            return LoginResults::TWO_FACTOR_REQUIRED;
        }

        auth()->login($user, $dto->remember);
        session()->regenerate();

        return LoginResults::SUCCESS;
    }

    private function findUser(LoginUserDTO $dto): User
    {
        return User::query()
            ->where($dto->loginType, $dto->login)
            ->first();
    }

    private function validateUser(User $user): void
    {
        if ($user->is_blocked) {
            throw LoginException::blocked();
        }

        if (! $user->activation?->completed) {
            throw LoginException::notActivated();
        }
    }

    private function prepareTwoFactor(User $user, bool $remember): void
    {
        session()->regenerate();
        session()->put([
            '2fa:user:id' => $user->id,
            '2fa:passed' => false,
            '2fa:remember' => $remember,
        ]);

    }
}

