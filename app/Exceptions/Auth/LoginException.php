<?php

namespace App\Exceptions\Auth;

use Exception;

class LoginException extends Exception
{
    public static function invalidCredentials(): self
    {
        return new self('Wrong credentials.');
    }

    public static function blocked(): self
    {
        return new self('Your account has been blocked.');
    }

    public static function notActivated(): self
    {
        return new self('Your account has not yet been activated, when approved you will get notified.');
    }
}