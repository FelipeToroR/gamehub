<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGameBadge extends Model
{
    public $fillable = [
        'game_badge_id',
        'game_id',
        'user_id'
    ];


    public function gameBadge()
    {
        return $this->belongsTo(\App\Models\GameBadge::class, 'game_badge_id', 'id');
    }

    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
