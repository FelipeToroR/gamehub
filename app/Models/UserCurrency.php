<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCurrency extends Model
{
    //


    public static function byUserGameInstance($user_id, $game_instance_id)
    {
        return UserCurrency::where('user_id', $user_id)->where('game_instance_id');
        
    }
}
