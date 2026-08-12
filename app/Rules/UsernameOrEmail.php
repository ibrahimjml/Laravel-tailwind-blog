<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
class UsernameOrEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(  string $attribute,  mixed $value,  Closure $fail): void 
    {
       if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return;
    }

    $validUsername = Validator::make(
        ['login' => $value],
        ['login' => ['alpha_num']]
      )->passes();

    if ($validUsername) {
        return;
    }

        $fail('Please enter a valid username or email address.');
    }
}