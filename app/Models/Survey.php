<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Survey
 * @package App\Models
 * @version April 7, 2020, 2:53 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection surveyResponses
 * @property string name
 * @property string description
 * @property string body
 */
class Survey extends Model
{

    public $table = 'surveys';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'type',
        'body',
        'experiment_id',
        'initial_date',
        'end_date',
		'responses_expected'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'body' => 'string',
		'responses_expected' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'body' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function surveyResponses()
    {
        return $this->hasMany(\App\Models\SurveyResponse::class, 'survey_id');
    }
}
