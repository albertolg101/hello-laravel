<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueLanguage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allData = request()->input($attribute);

        $languages = array_column($allData, 'language');

        if (count($languages) !== count(array_unique($languages))) {
            $fail('The language field must be unique across all elements.');
        }
    }
}
