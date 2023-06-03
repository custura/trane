<?php

namespace Custura\Trane\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AppointmentValidEndTimeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $start_time = request()->get('start_time');
        $start_date = request()->get('start_date');
        $end_date = request()->get('end_date');
        $end_time = $value;
        if($start_date == $end_date and $end_time <= $start_time or empty($end_date) and $end_time <= $start_time) {
            $fail('Start time value must be greater than End time');
        }
    }
}
