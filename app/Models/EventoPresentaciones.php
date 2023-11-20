<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoPresentaciones extends Model
{
    use HasFactory;

    protected $table = "evento_presentacion";
    protected $fillable = [
        "idevento_presentacion",
        "referencia_archivo",
        "nombre",
        "evento_id",
    ];
}
