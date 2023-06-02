<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GameParameter
 * @package App\Models
 * @version March 22, 2020, 11:34 pm UTC
 *
 * @property \App\Models\Game game
 * @property string name
 * @property string type
 * @property integer game_id
 */
class GameParameter extends Model
{
    //use SoftDeletes;

    public $table = 'game_parameters';
    
    public $fillable = [
        'name',
        'description',
        'type',
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
        'type' => 'string',
        'game_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }
}
