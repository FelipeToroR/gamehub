<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BagItemType
 * @package App\Models
 * @version July 17, 2020, 1:24 pm -04
 *
 * @property \App\Models\Game $game
 * @property \App\Models\Game $game
 * @property string $name
 * @property string $description
 * @property string $actions
 * @property integer $game_id
 */
class BagItemType extends Model
{
    use SoftDeletes;

    public $table = 'bag_item_types';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'actions',
        'game_id'
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
        'actions' => 'string',
        'game_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'actions' => 'json|required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }

}
