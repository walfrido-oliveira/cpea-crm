<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ParameterMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'preparation_method_id' => ['required', 'exists:preparation_methods,id'],
            'time_preparation' => ['required', 'numeric', 'max:999'],
            'type' => ['required', 'string',  Rule::in(['preparation', 'analysis'])],
        ];
    }
}
