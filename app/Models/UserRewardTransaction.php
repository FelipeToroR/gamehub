<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRewardTransaction extends Model
{
    protected $fillable = ['day_counter', 'game_instance_id', 'user_id'];
    public $timestamps = false;
}
