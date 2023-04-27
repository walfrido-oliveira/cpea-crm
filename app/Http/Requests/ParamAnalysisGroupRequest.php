<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParamAnalysisGroupRequest extends FormRequest
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
            'order' => ['required', 'string', 'max:255'],
            'final_validity' => ['required', 'date'],
            'parameter_analysis_group' => ['exists:parameter_analysis_groups,id', 'nullable'],
        ];
    }
}
