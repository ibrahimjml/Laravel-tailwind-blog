<?php

namespace App\DTOs\Auth;

class LoginUserDTO
{
  public function __construct(
    public readonly string $login,
    public readonly string $password,
    public readonly string $loginType,
    public readonly ?bool $remember,
  ) {
  }

  public static function fromRequest(array $validated): self
  {
    $login = $validated['login'];

    return new self(
      login: $login,
      password: $validated['password'],
      loginType: resolve_login_type($login),
      remember: (bool) ($validated['remember'] ?? false),
    );
  }

  public function credentials(): array
  {
    return [
      $this->loginType => $this->login,
      'password' => $this->password,
    ];
  }
}
