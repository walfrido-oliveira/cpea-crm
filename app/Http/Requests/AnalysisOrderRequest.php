<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalysisOrderRequest extends FormRequest
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
            'lab_id' => ['required', 'exists:labs,id'],
            'obs' => ['nullable', 'string', 'max:255'],
            'project_point_matrices.*' => ['required']
        ];
    }
}
