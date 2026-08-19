<?php

namespace App\Services\Auth;

use App\DTOs\Auth\LoginUserDTO;
use App\Enums\Auth\LoginResults;
use App\Exceptions\Auth\LoginException;
use App\Models\User;
use App\Services\User\TrustedDeviceService;

class LoginUserService
{
     public function __construct(
        protected TrustedDeviceService $trustedDevices,
        protected TwoFactorChallengeService $twoFactorService,
    ) {}

    public function handleLogin(LoginUserDTO $dto): LoginResults
    {
        if (! auth()->validate($dto->credentials())) {
            throw LoginException::invalidCredentials();
        }

        $user = $this->findUser($dto);

        $this->validateUser($user);

        if ($user->has_two_factor_enabled) {
           
            if ($this->trustedDevices->isTrusted(request(), $user)) {

                auth()->login($user, $dto->remember);
                request()->session()->regenerate();

                request()->session()->put([
                  '2fa:passed' => true,
                  '2fa:passed_at' => now()->timestamp
                  ]);
                
                return LoginResults::SUCCESS;
            }

            $this->twoFactorService->prepareLoginChallenge($user, $dto->remember);

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
}

