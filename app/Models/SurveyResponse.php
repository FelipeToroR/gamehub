<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    public $table = 'survey_responses';
    
    public $fillable = [
        'test',
        'label',
        'question',
        'response',
        'user_id',
        'experiment_id'
    ];

}

