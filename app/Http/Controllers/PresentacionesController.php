<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoPresentaciones;

class PresentacionesController extends Controller
{
    public function getPresentacionesPorEvento($idEvento)
    {
        $presentaciones = EventoPresentaciones::where('evento_id', $idEvento)->get();

        return response()->json($presentaciones);
    }
}