<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'evento';

    protected $fillable = [
        'id', 
        'nombre',
        'fecha', 
        'hora_inicio', 
        'hora_fin', 
        'es_visible', 
        'tipo_evento', 
        'tipo_invitacion', 
        'descripcion', 
        'ubicacion_id', 
        'evento_anterior_id', 
        'presentador_asistente_id', 
        'usuario_id'
    ];

    public function asistentes()
    {
        return $this->hasMany(Asistente::class, 'participante_id');
    }

    public function presentaciones()
    {
        return $this->hasMany(EventoPresentaciones::class, 'idevento_presentacion', 'id');
    }
}
