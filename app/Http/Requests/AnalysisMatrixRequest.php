<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AnalysisMatrixRequest extends FormRequest
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
        $analysis_matrix = $this->analysis_matrix;
        return [
            'name' => ['required', 'string', 'max:255'],
            'analysis_matrix_id' => ['required', 'string', 'max:255', Rule::unique('analysis_matrices', 'analysis_matrix_id')->ignore($analysis_matrix)],
        ];
    }
}
