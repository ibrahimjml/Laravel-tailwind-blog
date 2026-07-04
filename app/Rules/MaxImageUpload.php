<?php

namespace App\Rules;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxImageUpload implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value) {
            return;
        }
        
        $maxMb = (bool) Setting::get('enable_image_optimization')
                 ? (int) Setting::get('image_max_upload_size')
                 : 5;

        $maxBytes = $maxMb * 1024 * 1024;

        if ($value->getSize() > $maxBytes) {
            $fail("The {$attribute} may not be greater than {$maxMb} MB.");
        }
    }
    }

