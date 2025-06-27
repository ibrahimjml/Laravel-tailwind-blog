<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    public function __construct(
      private ?User $user = null,
      private array $reserved = [
            '0',
            'about',
            'access',
            'account',
            'accounts',
            'activate',
            'activities',
            'activity',
            'ad',
            'add',
            'address',
            'adm',
            'admin',
            'administration',
            'administrator',
            'ads',
            'adult',
            'advertising',
            'affiliate',
            'affiliates',
            'ajax',
            'all',]){}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(in_array($value,$this->reserved,true)){
          $fail('The :attribute is reserved.');
          return;
        }
        if($this->user->username_changed_at !== null && $this->user->username !== $value){
          $fail('You can update your username only once.');
        }
    }
}
