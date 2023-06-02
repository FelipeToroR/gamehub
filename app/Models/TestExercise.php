<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TestExercise
 * @package App\Models
 * @version March 29, 2020, 1:52 am UTC
 *
 * @property string exercise
 * @property string user_response
 * @property string response
 * @property json extra
 */
class TestExercise extends Model
{
    public $table = 'test_exercises';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'test',
        'label',
        'exercise',
        'user_response',
        'response',
        'score',
        'lives',
        'extra'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'event' => 'integer',
        'test' => 'string',
        'label' => 'string',
        'exercise' => 'string',
        'user_response' => 'string',
        'response' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
}
