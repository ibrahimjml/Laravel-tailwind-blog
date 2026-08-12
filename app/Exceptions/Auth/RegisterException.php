<?php

namespace App\Exceptions\Auth;

use RuntimeException;

class RegisterException extends RuntimeException
{
     public function __construct()
    {
        parent::__construct('Unable to create your account. Please try again.');
    }
}
