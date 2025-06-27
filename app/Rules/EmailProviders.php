<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailProviders implements ValidationRule
{
   public function __construct(
    private array $unauthorizedemails=[
      'tempmail.com',
      'example.com',
      'mailinator.com',
      'tempail.com',
    ]
   ){}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
      if (!str_contains($value, '@')) {
           $fail('The :attribute doesnot have an @.');
           return;
         }  
         [$user, $domain] = explode('@', $value);
         
        if (in_array($domain, $this->unauthorizedemails, true)) {
        $fail('The :attribute belongs to an unauthorized email provider.');
        return;
    }

    }
}
