<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RewardDayItem
 * @package App\Models
 * @version July 17, 2020, 1:47 pm -04
 *
 * @property \App\Models\RewardDay $rewardDay
 * @property \App\Models\BagItemType $bagItemType
 * @property integer $quantity
 * @property integer $reward_day_id
 * @property integer $bag_item_type_id
 */
class RewardDayItem extends Model
{
    use SoftDeletes;

    public $table = 'reward_day_items';
    

    protected $dates = ['deleted_at'];


    protected $primaryKey = 'bag_item_type_id';

    public $fillable = [
        'quantity',
        'reward_day_id',
        'bag_item_type_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'quantity' => 'integer',
        'reward_day_id' => 'integer',
        'bag_item_type_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quantity' => 'required',
        'reward_day_id' => 'required',
        'bag_item_type_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rewardDay()
    {
        return $this->belongsTo(\App\Models\RewardDay::class, 'reward_day_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bagItemType()
    {
        return $this->belongsTo(\App\Models\BagItemType::class, 'bag_item_type_id', 'id');
    }
}
