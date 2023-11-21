<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PresentadorController extends Controller
{
    public function presentador(Request $request)
    {
        $referenciaArchivo = session('referenciaArchivo');

        return view('presentador.presentador', compact('referenciaArchivo'));
    }

    public function volver()
    {
        // Limpiar la referencia del archivo de la sesión
         Session::forget('referenciaArchivo');

        // Redirigir o hacer cualquier otra cosa que necesites hacer al volver
        return redirect()->route('eventos.index');
    }


    public function presentacion(Request $request)
    {
        $referenciaArchivo = session('referenciaArchivo');

        return view('presentador.presentacion', compact('referenciaArchivo'));
    }


}
