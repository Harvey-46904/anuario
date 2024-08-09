<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class Anuariosfin extends Model
{
    protected $fillable = [
        
        'id_colegio',
        'nombre',
        'anio',
    ];
    public function scopeCurrentUser($query)
    {
        // Obtén el ID del usuario autenticado
        $userId = Auth::user()->id;


       
        return $query->join('anuariousers', 'anuariousers.id_anuario', '=', 'anuariosfins.id')
                     ->where('anuariousers.id_user', $userId);
    }
}
