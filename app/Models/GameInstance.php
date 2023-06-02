<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Services\EncryptService;
/**
 * Class GameInstance
 * @package App\Models
 * @version March 22, 2020, 10:49 pm UTC
 *
 * @property \App\Models\Game game
 * @property string name
 * @property string description
 * @property integer game_id
 */
class GameInstance extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;


    public $table = 'game_instances';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'game_id',
        'experiment_id',
        'reward_id',
        'enable_rewards',
        'enable_badges',
        'enable_performance_chart',
        'enable_leaderboard'
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
        'game_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:30',
        'slug' => 'unique:gameinstances'
    ];


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return $this->getSlugKeyName();
    }


    protected $appends = ['token', 'hash', 'game_slug'];


    public function getTokenAttribute()
    {
        return (new EncryptService())->encrypt_decrypt('encrypt', trim($this->slug));
    }

    public function getHashAttribute()
    {
        return md5((new EncryptService())->encrypt_decrypt('encrypt', $this->slug));
    }

    
    public function getGameSlugAttribute()
    {
        return $this->game->slug;
    }


    public static function findByEncryptedToken($token)
    {
        // Desencripta token para convertir a slug de game_instance
        $game_instance_slug = (new EncryptService())->encrypt_decrypt('decrypt', urldecode($token));
        return GameInstance::where('slug', $game_instance_slug)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }
    
    public function experiment()
    {
        return $this->belongsTo(\App\Models\Experiment::class, 'experiment_id', 'id');
    }

    public function instance_parameters()
    {
        return $this->hasMany('App\Models\GameInstanceParameter', 'game_instance_id', 'id');
    }

    public function exercises()
    {
        return $this->hasMany('App\Models\GameExercise', 'game_instance_id', 'id');
    }

}
