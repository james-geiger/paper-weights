<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreexerciseRequest extends FormRequest
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
            'name' => 'required|string',
            'workout_id' => 'nullable|uuid',
            'order' => 'nullable|numeric'
        ];
    }
}
