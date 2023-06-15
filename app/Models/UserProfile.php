<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{


    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'description',
        'profile_image',
        'birthdate',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
