<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserLogin
 * @package App\Models
 * @version April 2, 2020, 10:57 pm UTC
 *
 * @property \App\Models\Users user
 * @property \App\Models\Experiment experiment
 * @property integer user_id
 * @property integer experiment_id
 * @property integer enabled
 */
class UserLogin extends Model
{
    //use SoftDeletes;
    

    public $table = 'user_login';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
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

}
