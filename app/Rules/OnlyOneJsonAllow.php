<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyOneJsonAllow implements Rule
{
    /**
     * @var array
     */
    public array $requests;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($requests)
    {
        $this->requests = $requests;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return count($this->requests) == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.only_one_json_is_allow');
    }
}
