<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GameExercise
 * @package App\Models
 * @version March 29, 2020, 1:52 am UTC
 *
 * @property string exercise
 * @property string user_response
 * @property string response
 * @property json extra
 */
class GameExercise extends Model
{

    public $table = 'game_exercises';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'round',
        'type',
        'exercise',
        'user_response',
        'response',
        'memory_origin',
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
        'round' => 'integer',
        'exercise' => 'string',
        'user_response' => 'string',
        'response' => 'string',
        'score'=> 'integer',
        'lives'=> 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
