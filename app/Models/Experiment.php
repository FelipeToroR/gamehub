<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Experiment
 * @package App\Models
 * @version April 2, 2020, 10:45 pm UTC
 *
 * @property string name
 * @property string description
 * @property integer status
 */
class Experiment extends Model
{
    use SoftDeletes;

    public $table = 'experiments';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'description',
        'status',
        'time_limit'
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
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'status' => 'required'
    ];

    public function surveys()
    {
        return $this->hasMany('App\Models\Survey', 'experiment_id', 'id');
    }


    public function gameInstances()
    {
        return $this->hasMany('App\Models\GameInstance', 'experiment_id', 'id');
    }
    
}
