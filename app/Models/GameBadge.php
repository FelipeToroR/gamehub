<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class GameBadge
 * @package App\Models
 * @version August 6, 2020, 1:32 pm -04
 *
 * @property \App\Models\Game $game
 * @property string $name
 * @property string $description
 * @property string $conditions
 * @property integer $game_id
 */
class GameBadge extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;

    public $table = 'game_badges';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'name',
        'description',
        'conditions',
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
        'conditions' => 'string',
        'game_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('badges')
            ->useFallbackPath(public_path('/assets/gamification/badge_default.png'))
            ->singleFile();
    }
}
