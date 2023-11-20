<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    protected $table = 'asistente';

    protected $fillable = [
        'id',
        'esta_aceptado',
        'es_administrador',
        'activo',
        'evento_id',
        'participante_id',
        'rol_id',
        'asistencia_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id');
    }
}

