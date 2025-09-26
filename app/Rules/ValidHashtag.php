<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidHashtag implements ValidationRule
{
    protected $max = 5;


    public function __construct(int $max = 5)
    {
        $this->max = $max;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
          $tags = array_filter(array_map('trim', explode(',', $value)));

          if (count($tags) > $this->max) {
              $fail('You can only select up to 5 hashtags.');
          }

          $regexTags = '/^[A-Za-z0-9_-]+$/';
          
          foreach( $tags as $tag){
            if(!preg_match($regexTags,$tag)){
              $fail("Hashtags only contain letters, numbers, dashes, or underscores");
            }

             $exists = \App\Models\Hashtag::where('name', $tag)
                         ->where('status', \App\Enums\TagStatus::ACTIVE)
                         ->exists();
                    if(!$exists){
                      $fail("The hashtag '{$tag}' is disabled.");
                    }
          }
    }
}
