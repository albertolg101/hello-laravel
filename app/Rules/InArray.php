<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InArray implements ValidationRule
{
    public function __construct(protected string $path, protected array $array) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = PathReducer::reduce($this->path, request()->input($attribute), true);

        if (count(array_diff($data, $this->array)) > 0) {
            $fail("The $attribute field must be in the array $this->array.");
        }
    }
}
