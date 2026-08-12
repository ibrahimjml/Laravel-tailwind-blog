<?php

namespace App\Services\Auth;

use App\Actions\Auth\CreateUserAction;
use App\Actions\CreateUserActivationAction;
use App\DTOs\Auth\RegisterUserDTO;
use App\Events\NewRegistered;
use App\Exceptions\Auth\RegisterException;
use App\Mail\WelcomeNewUser;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class RegisterUserService
{
  protected $factory;
  public function __construct(
    protected CreateUserAction $createUserAction,
    protected CreateUserActivationAction $createUserActivationAction
  ) {
  }
  public function register(RegisterUserDTO $dto): array
  {
    try {
      $user = DB::transaction(function () use ($dto) {
        $user = $this->createUserAction->execute($dto);

        $this->assignDefaultRole($user);

        $this->createUserActivationAction->create($user);

         DB::afterCommit(function () use ($user) {
                Mail::to($user->email)->queue(new WelcomeNewUser($user));

                event(new NewRegistered($user));
            });

        return $user;
      });

    } catch (\Throwable $e) {
      Log::error('User registration failed.', [
        'email' => $dto->email,
        'username' => $dto->username,
        'exception' => $e,
      ]);

      throw new RegisterException();
    }
    
      return [
        'user' => $user,
        'message' => 'Your account has been registered, we will email you once activated.',
      ];
  }
  private function assignDefaultRole($user): void
  {
    $role = Role::firstOrCreate(['name' => 'User']);
    $user->roles()->syncWithoutDetaching([$role->id]);
  }
}
