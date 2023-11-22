<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoPresentaciones;

class PresentacionesController extends Controller
{
    public function getPresentacionesPorEvento($idEvento)
    {
        // Realiza la consulta para obtener las presentaciones del evento
        $presentaciones = EventoPresentaciones::where('evento_id', $idEvento)->get();

        // Devuelve las presentaciones en formato JSON
        return response()->json($presentaciones);
    }
}