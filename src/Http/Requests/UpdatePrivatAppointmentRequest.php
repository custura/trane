<?php

namespace Custura\Trane\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Custura\Trane\Rules\AppointmentValidEndTimeRule;

class UpdatePrivatAppointmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => [
                'required', 'min:3', 'max:50', 'string',
            ],
            'start_date' => [
                'date', 'required',
            ],
            'end_date' => [
                'date', 'after_or_equal:start_date', 'nullable',
            ],
            'start_time' => [
                'date_format:"H:i"', 'required',
            ],
            'end_time' => [
                'date_format:"H:i"', 'nullable', new AppointmentValidEndTimeRule,
            ],
        ];
    }

    public function authorize()
    {
        return Gate::allows('privat_appointment_access');
    }
}
