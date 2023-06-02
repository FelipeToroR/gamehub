<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExperimentEntrypoint
 * @package App\Models
 * @version July 6, 2020, 11:54 pm -04
 *
 * @property \App\Models\Experiment $experiment
 * @property string $title
 * @property string $information
 * @property integer $obfuscated
 */
class ExperimentEntrypoint extends Model
{
    use SoftDeletes;

    public $table = 'experiment_entrypoints';
    

    protected $dates = ['deleted_at'];


    protected $primaryKey = 'token';

    public $fillable = [
        'token',
        'title',
        'information',
        'obfuscated',
        'experiment_id',
        'default_college',
        'default_course'
    ];

    public $incrementing = false;


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'token' => 'string',
        'title' => 'string',
        'information' => 'string',
        'obfuscated' => 'integer',
        'experiment_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'token' => 'required',
        ''
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function experiment()
    {
        return $this->belongsTo(\App\Models\Experiment::class, 'experiment_id', 'id');
    }
}
