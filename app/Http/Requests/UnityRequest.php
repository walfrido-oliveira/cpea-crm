<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnityRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'unity_cod' => ['required', 'string', 'max:255', 'unique:unities,unity_cod,' . $this->unity],
            'geodetic_system_id' => ['nullable', 'exists:unities,id'],
            'conversion_amount' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
        ];
    }
}
