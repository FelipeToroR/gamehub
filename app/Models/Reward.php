<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Reward
 * @package App\Models
 * @version July 14, 2020, 8:34 pm -04
 *
 * @property string $name
 * @property string $description
 */
class Reward extends Model
{

    public $table = 'rewards';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
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
        'name' => 'required'
    ];

    
}
