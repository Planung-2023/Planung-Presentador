<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\EventoPresentaciones;
use Illuminate\Support\Facades\Session;

class EventosController extends Controller
{
    public function misEventos()
    {
        // Obtener el usuario autenticado actualmente
        $userInfo = session('auth0_user');
        $user = session('usuario_laravel');

        if($userInfo == null){
            return redirect()->route('login');
        }

        // Obtener el modelo Usuario correspondiente al usuario logueado
        $usuario = Usuario::where('email', $user['email'])->first();
        Log::info('usuario de auth0');
        Log::info($userInfo);
        Log::info('usuario de laravel');
        Log::info($user);
        Log::info('usuario de la db');
        Log::info($usuario);

        // Verificar si el usuario existe
        if ($usuario) {
            // Obtener los eventos en los que el usuario es asistente utilizando Eloquent
            $eventos = Evento::whereHas('asistentes', function ($query) use ($usuario) {
                $query->where('id', $usuario->id);
            })->get();

            $presentaciones = EventoPresentaciones::all();

            // Pasar los eventos a la vista 'index'
            return view('index', compact('eventos', 'presentaciones'));
        }
        else{
            return redirect()->route('login');
        }
        
    }

    public function subirPresentacion($idEvento)
    {
        $evento = Evento::findOrFail($idEvento);
        return view('includes.popups.subir-presentacion', compact('evento'));
    }

    public function guardarPresentacion(Request $request, $idEvento)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $evento = Evento::findOrFail($idEvento);

        // Subir el archivo PDF
        $pdf = $request->file('pdf');
        $nombreArchivo = $pdf->getClientOriginalName();
        $rutaRelativa = 'archivos/' . $nombreArchivo;

        // Deshabilitar timestamps
        EventoPresentaciones::flushEventListeners();

        // Guardar la información en la base de datos sin timestamps
        $presentacion = EventoPresentaciones::create([
            'referencia_archivo' => $rutaRelativa,
            'nombre' => $nombreArchivo,
            'evento_id' => $evento->id,
        ]);

        // Puedes enviar la referencia del archivo como un parámetro en la redirección
        return redirect()->route('eventos.index', ['referenciaArchivo' => $presentacion->referencia_archivo])->with('success', 'Presentación subida exitosamente.');
    }

    public function guardarReferenciaArchivo(Request $request)
    {
        $referenciaArchivo = $request->input('referenciaArchivo');

        // Guardar la referencia del archivo en la sesión
        session(['referenciaArchivo' => $referenciaArchivo]);

        return response()->json(['success' => true]);
    }

    public function presentador(Request $request)
    {
        $referenciaArchivo = session('referenciaArchivo');
        return view('presentador.presentador', compact('referenciaArchivo'));
    }

/*
    public function volver()
    {
        // Limpiar la referencia del archivo de la sesión
         Session::forget('referenciaArchivo');

        // Redirigir o hacer cualquier otra cosa que necesites hacer al volver
        return redirect()->route('eventos.index');
    }
*/

    public function presentacion(Request $request)
    {
        $referenciaArchivo = $request->query('referenciaArchivo');
        return view('presentador.presentacion', compact('referenciaArchivo'));
    }



}
