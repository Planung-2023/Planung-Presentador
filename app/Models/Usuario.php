<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Usuario extends Authenticatable implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'usuario';
    
    protected $fillable = [
        'id',
        'idAuth0',
        'nombre_usuario',
        'email',
        'nombre',
        'apellido',
        'foto_perfil_id',
    ];

    protected $primaryKey = 'id';

    public function eventosAsistidos()
    {
        return $this->hasMany(Asistente::class, 'id');
    }
}
