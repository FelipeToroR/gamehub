<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\GameInstance;

class UpdateGameInstanceRequestGamification extends FormRequest
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
        $rules = [
            'enable_rewards' => 'numeric|max:1',
            'reward_id' => 'nullable|numeric|max:1|required_with:enable_rewards,1',
            'enable_performance_chart' => 'numeric|max:1',
            'enable_badges' => 'numeric|max:1',
            'enable_learderboard' => 'numeric|max:1'
        ];
        
        return $rules;
    }
}
