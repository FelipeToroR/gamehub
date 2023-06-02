<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'profile_image',
        'birthdate',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
