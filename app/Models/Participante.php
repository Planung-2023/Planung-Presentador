<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participante';

    protected $fillable = [
        'id',
        'usuario_id',
        'nombre',
        'apellido',
        'mail'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function eventosAsistidos()
    {
        return $this->hasMany(Asistente::class, 'participante_id');
    }
}
