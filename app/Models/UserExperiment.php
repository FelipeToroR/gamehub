<?php

namespace App\Models;

use App\Models\UserLogin;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserExperiment
 * @package App\Models
 * @version April 2, 2020, 10:57 pm UTC
 *
 * @property \App\Models\Users user
 * @property \App\Models\Experiment experiment
 * @property integer user_id
 * @property integer experiment_id
 * @property integer enabled
 */
class UserExperiment extends Model
{
    //use SoftDeletes;
    

    public $table = 'user_experiments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'experiment_id',
        'game_instance_id',
		'actual_responses'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'experiment_id' => 'integer',
        'game_instance_id' => 'integer',
		'actual_responses' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
       
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function experiment()
    {
        return $this->belongsTo(\App\Models\Experiment::class, 'experiment_id', 'id');//->where('id', 1)->first();
    }

    public function gameInstance()
    {
        return $this->belongsTo(\App\Models\GameInstance::class, 'game_instance_id', 'id');//->where('id', 1)->first();
    }

}
