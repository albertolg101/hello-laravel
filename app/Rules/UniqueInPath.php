<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueInPath implements ValidationRule
{
    public function __construct(protected string $path) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = PathReducer::reduce($this->path, request()->input($attribute), true);

        if (count($data) !== count(array_unique($data))) {
            $fail("The $attribute field must be unique in the path $this->path.");
        }
    }
}
