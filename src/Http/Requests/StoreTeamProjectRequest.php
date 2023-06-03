<?php

namespace Custura\Trane\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Custura\Trane\Trane;

class StoreTeamProjectRequest extends FormRequest
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
            'description' => [
                'required', 'min:3', 'max:250', 'string',
            ],
            'title' => [
                'required', 'min:3', 'max:15', 'string',
            ],
        ];
    }

}
