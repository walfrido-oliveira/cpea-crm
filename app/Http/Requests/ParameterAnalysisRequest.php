<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParameterAnalysisRequest extends FormRequest
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
            'analysis_parameter_id' => ['required', 'exists:analysis_parameters,id'],
            'parameter_analysis_group_id' => ['required', 'exists:parameter_analysis_groups,id'],
            'cas_rn' => ['nullable', 'string', 'max:255'],
            'analysis_parameter_name' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'numeric', 'max:999'],
            'decimal_place' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'final_validity' => ['date', 'nullable'],
        ];
    }
}
