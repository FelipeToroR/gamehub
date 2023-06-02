<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserBagItem
 * @package App\Models
 * @version July 17, 2020, 1:37 pm -04
 *
 * @property \App\Models\Users $user
 * @property \App\Models\GameInstance $gameInstance
 * @property \App\Models\BagItemType $bagItemType
 * @property integer $quantity
 * @property integer $user_id
 * @property integer $game_instance_id
 * @property integer $bag_item_type_id
 */
class UserBagItem extends Model
{
    use SoftDeletes;

    public $table = 'user_bag_items';
    

    protected $dates = ['deleted_at'];


    protected $primaryKey = 'bag_item_type_id';

    public $fillable = [
        'quantity',
        'user_id',
        'game_instance_id',
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
        'user_id' => 'integer',
        'game_instance_id' => 'integer',
        'bag_item_type_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quantity' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\Users::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gameInstance()
    {
        return $this->belongsTo(\App\Models\GameInstance::class, 'game_instance_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bagItemType()
    {
        return $this->belongsTo(\App\Models\BagItemType::class, 'bag_item_type_id', 'id');
    }
}
