<?php 

namespace App\Enums\Auth;
enum LoginResults: string
{
    case SUCCESS = 'success';
    case TWO_FACTOR_REQUIRED = 'two_factor_required';
}