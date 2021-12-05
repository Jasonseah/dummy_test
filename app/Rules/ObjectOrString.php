<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ObjectOrString implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // is array is because if pass as json it will be automated become json
        return is_array($value) || is_string($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.custom.object_or_string');
    }
}
