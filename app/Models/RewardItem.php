<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class RewardItem
 * @package App\Models
 * @version July 14, 2020, 9:24 pm -04
 *
 * @property \App\Models\Experiment $experiment
 * @property string $name
 * @property string $description
 * @property integer $currencyAmount
 * @property integer $experiment_id
 */
class RewardItem extends Model
{

    public $table = 'reward_items';
    

    protected $dates = ['deleted_at'];


    protected $primaryKey = 'experiment_id';

    public $fillable = [
        'name',
        'description',
        'currencyAmount',
        'experiment_id'
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
        'currencyAmount' => 'integer',
        'experiment_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function experiment()
    {
        return $this->belongsTo(\App\Models\Experiment::class, 'experiment_id', 'id');
    }
}
