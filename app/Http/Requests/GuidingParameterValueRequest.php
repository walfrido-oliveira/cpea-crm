<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuidingParameterValueRequest extends FormRequest
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
            'guiding_parameter_id' => ['required', 'exists:guiding_parameters,id'],
            'analysis_matrix_id' => ['required', 'exists:analysis_matrices,id'],
            'parameter_analysis_id' => ['required', 'exists:parameter_analyses,id'],
            'guiding_parameter_ref_value_id' => ['nullable', 'exists:guiding_parameter_ref_values,id'],
            'guiding_value_id' => ['required', 'exists:guiding_values,id'],
            'unity_legislation_id' => ['required', 'exists:unities,id'],
            //'unity_analysis_id' => ['required', 'exists:unities,id'],
            'guiding_legislation_value' => ['string', 'nullable'],
            'guiding_legislation_value_1' => ['string', 'nullable'],
            'guiding_legislation_value_2' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'guiding_analysis_value' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'guiding_analysis_value_1' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'guiding_analysis_value_2' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
        ];
    }
}
