<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuidingParameterRequest extends FormRequest
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
            'environmental_area_id' => ['exists:environmental_areas,id', 'nullable'],
            'environmental_agency_id' => ['exists:environmental_agencies,id', 'nullable'],
            'customer_id' => ['exists:customers,id', 'nullable'],
            'name' => ['required', 'string', 'max:255'],
            'resolutions' => ['nullable', 'string', 'max:255'],
            'articles' => ['nullable', 'string', 'max:255'],
            'observation' => ['nullable', 'string', 'max:255'],
        ];
    }
}
