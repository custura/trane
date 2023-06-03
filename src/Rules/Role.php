<?php

namespace Custura\Trane\Rules;

use Illuminate\Contracts\Validation\Rule;
use Custura\Trane\Trane;

class Role implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, array_keys(Trane::$roles));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be a valid role.');
    }
}
