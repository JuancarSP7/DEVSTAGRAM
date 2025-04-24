<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [ //los atributos del modelo Follower que se pueden asignar en masa a la base de datos
        'user_id',
        'follower_id'
    ];
}
