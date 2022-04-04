<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetRequest extends FormRequest
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
            'log_id' => 'required|uuid',
            'order' => 'required|numeric',
            'reps' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'sets' => 'required|numeric',
            'reps' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'duration_hours' => 'nullable|numeric',
            'duration_minutes' => 'nullable|numeric',
            'duration_seconds' => 'nullable|numeric',
            'distance' => 'nullable|numeric',
            'distance_unit' => 'required_with:distance|uuid'
        ];
    }
}
