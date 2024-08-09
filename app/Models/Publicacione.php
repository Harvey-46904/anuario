<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Publicacione extends Model
{
    protected $fillable = [
        'foto',
        'descripcion',
        'id_anuario',
        'id_user',
        'moderada'
        
    ];
}
