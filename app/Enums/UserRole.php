<?php

namespace App\Enums;

enum UserRole :string
{
    case ADMIN = 'Admin';
    case MODERATOR = 'Moderator';
    case USER = 'User';
}
