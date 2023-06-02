<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GameInstanceParameter
 * @package App\Models
 * @version March 23, 2020, 11:01 pm UTC
 *
 * @property \App\Models\GameInstance gameInstance
 * @property \App\Models\GameParameter gameParameter
 * @property string slug
 * @property string name
 * @property string description
 * @property integer game_instance_id
 * @property integer game_parameter_id
 */
class GameInstanceParameter extends Model
{
    public $table = 'game_instance_parameters';
    
    public $fillable = [
        'name',
        'description',
        'game_instance_id',
        'game_parameter_id'
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
        'game_instance_id' => 'integer',
        'game_parameter_id' => 'integer'
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
    public function gameInstance()
    {
        return $this->belongsTo(\App\Models\GameInstance::class, 'game_instance_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gameParameter()
    {
        return $this->belongsTo(\App\Models\GameParameter::class, 'game_parameter_id', 'id');
    }

    protected $appends = ['variable', 'type', 'experiment_id'];


    public function getVariableAttribute()
    {
        return $this->gameParameter->name;// 'var';//(new EncryptService())->encrypt_decrypt('encrypt', $this->slug);
    }

    public function getTypeAttribute()
    {
        return 'int';//(new EncryptService())->encrypt_decrypt('encrypt', $this->slug);
    }

    public function getExperimentIdAttribute(){
        return $this->gameInstance->experiment_id;
    }
}
