<?php

namespace Custura\Trane\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Custura\Trane\Trane;

class UpdateTeamProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required', 'min:3', 'max:20', 'string',
            ],
            'description' => [
                'nullable', 'min:3', 'max:250', 'string',
            ],
            'pause_time_1' => [
                'date_format:"H:i"', 'nullable',
            ],
            'pause_time_2' => [
                'date_format:"H:i"', 'nullable',
            ],
            'pause_time_3' => [
                'date_format:"H:i"', 'nullable',
            ],
            'pause_time_4' => [
                'date_format:"H:i"', 'nullable',
            ],
            'work_time_1' => [
                'date_format:"H:i"', 'nullable',
            ],
            'work_time_2' => [
                'date_format:"H:i"', 'nullable',
            ],
            'work_time_3' => [
                'date_format:"H:i"', 'nullable',
            ],
            'work_time_4' => [
                'date_format:"H:i"', 'nullable',
            ],
            'tasks' => [
                'nullable',
            ],
            'status' => [
                'nullable',
            ],
        ];
    }

}
