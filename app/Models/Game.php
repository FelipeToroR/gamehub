<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Game
 * @package App\Models
 * @version March 22, 2020, 10:48 pm UTC
 *
 * @property string name
 * @property string description
 */
class Game extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'games';
    

    protected $dates = ['deleted_at'];

    protected $attributes = [
        'extra' => '{}'
    ];

    public $fillable = [
        'slug',
        'name',
        'description',
        'width',
        'height',
        'proportion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'slug' => 'required',
        'name' => 'required'
    ];

    protected static function boot()
    {
        parent::boot();

        /* Game::saving(function ($model) {
            $model->slug = str_slug($model->name);
        }); */

        Game::creating(function ($item) {
            $item->slug = Str::slug($item->name, '-'); //assigning value
        });

    }

    public function parameters()
    {
        return $this->hasMany('App\Models\GameParameter', 'game_id', 'id');
    }

    
}
