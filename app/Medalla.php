<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medalla extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'imagen'];
}
