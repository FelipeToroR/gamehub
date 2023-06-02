<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Survey;

class UpdateSurveyRequest extends FormRequest
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
        $rules = Survey::$rules;
        
        return [
            'type' => 'required',
            'initial_date' => 'required_if:type,2|date',
            'end_date' => 'required_if:type,2|date',
        ];
    }

    public function messages() {
        return [
            'initial_date.required_if' => 'Se requiere especificar la fecha de inicio, si habilitará por tramo de fechas', // Works
            'end_date.required_if' => 'Se requiere especificar la fecha de término, si habilitará por tramo de fechas', // Fails
        ];
    }
}
