<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class users
 * @package App\Models
 * @version April 4, 2020, 9:44 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection gameExercises
 * @property \Illuminate\Database\Eloquent\Collection gameInstanceScores
 * @property \Illuminate\Database\Eloquent\Collection gameInstanceTimes
 * @property \Illuminate\Database\Eloquent\Collection experiments
 * @property string name
 * @property string email
 * @property string|\Carbon\Carbon email_verified_at
 * @property string password
 * @property string remember_token
 */
class users extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameExercises()
    {
        return $this->hasMany(\App\Models\GameExercise::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameInstanceScores()
    {
        return $this->hasMany(\App\Models\GameInstanceScore::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameInstanceTimes()
    {
        return $this->hasMany(\App\Models\GameInstanceTime::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function experiments()
    {
        return $this->belongsToMany(\App\Models\Experiment::class, 'user_experiments');
    }

    public function userProfile()
{
    return $this->hasOne(UserProfile::class, 'user_id');
}
}
