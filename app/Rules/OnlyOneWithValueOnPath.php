<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyOneWithValueOnPath implements ValidationRule
{
    public function __construct(protected string $path, protected $value) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = PathReducer::reduce($this->path, request()->input($attribute), true);

        $count = 0;
        foreach ($data as $item) {
            if ($item === $this->value) {
                $count++;
            }
        }

        if ($count !== 1) {
            $fail("The $attribute field must have only one value $this->value in the path $this->path.");
        }
    }
}
