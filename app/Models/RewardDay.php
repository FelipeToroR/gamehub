<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RewardDay
 * @package App\Models
 * @version July 17, 2020, 1:17 pm -04
 *
 * @property \App\Models\Reward $reward
 * @property integer $day
 * @property integer $reward_id
 */
class RewardDay extends Model
{
    use SoftDeletes;

    public $table = 'reward_days';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'day',
        'reward_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'day' => 'integer',
        'reward_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'day' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function reward()
    {
        return $this->belongsTo(\App\Models\Reward::class, 'reward_id', 'id');
    }
}
