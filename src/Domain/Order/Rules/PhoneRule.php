<?php

namespace Domain\Order\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_numeric($value)) {
            $fail('Введите телефон, состоящий из цифр');
        }

        if (strlen($value) < 11) {
            $fail('Введите мобильный номер телефона');
        }
    }
}
