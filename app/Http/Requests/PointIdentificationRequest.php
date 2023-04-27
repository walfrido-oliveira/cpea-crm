<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PointIdentificationRequest extends FormRequest
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
        $area = $this->request->get('area');
        $identification = $this->request->get('identification');
        return [
            'area' => ['required', 'string', 'max:255'],
            'identification' => ['required', 'string', 'max:255', Rule::unique('point_identifications')->where(function ($query) use($area, $identification) {
                return $query->where('area', $area)
                ->where('identification', $identification);
            }),],
            'utm_me_coordinate' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'utm_mm_coordinate' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pool_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pool_diameter' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'pool_volume' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'water_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'water_collection_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'sedimentary_collection_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
            'collection_depth' => ['regex:(\d+(?:,\d{1,2})?)', 'nullable'],
        ];
    }
}
