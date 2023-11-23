<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPerfil extends Model
{
    use HasFactory;

    protected $table = 'foto_perfil';

    protected $fillable = [
        'id',
        'nombre',
    ];
}
