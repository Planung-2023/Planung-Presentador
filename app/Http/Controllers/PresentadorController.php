<?php

namespace App\Http\Controllers;

use App\Models\EventoPresentaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PresentadorController extends Controller
{
    public function presentador($idevento_presentacion)
    {
        $referenciaPresentacion = EventoPresentaciones::where('idevento_presentacion', $idevento_presentacion)->first();
        return view('presentador.presentador', compact('referenciaPresentacion'));
    }

    public function volver()
    {
        return redirect()->route('eventos.index');
    }


    public function presentacion($idevento_presentacion)
    {
        $referenciaPresentacion = EventoPresentaciones::where('idevento_presentacion', $idevento_presentacion)->first();
        return view('presentador.presentacion', compact('referenciaPresentacion'));
    }


}
