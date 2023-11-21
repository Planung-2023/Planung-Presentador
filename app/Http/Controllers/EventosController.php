<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\EventoPresentaciones;

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
            $eventos = Evento::select('evento.nombre', 'evento.fecha', 'evento.descripcion', 'evento.id')
            ->join('asistente', 'evento.id', '=', 'asistente.evento_id')
            ->join('usuario', 'asistente.participante_id', '=', 'usuario.id')
            ->where('evento.tipo_evento', 'Formal')
            ->where('usuario.id', $usuario->id)
            ->distinct()
            ->get();

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

    public function guardarPresentacion(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $idEvento = $request->input('idEvento');

        $evento = Evento::findOrFail($idEvento);

        // Subir el archivo PDF
        $pdf = $request->file('pdf');
        $nombreArchivo = $pdf->getClientOriginalName();
        $rutaRelativa = 'storage/archivos/' . $nombreArchivo;

        // Deshabilitar timestamps
        EventoPresentaciones::flushEventListeners();

        // Guardar la información en la base de datos sin timestamps
        $presentacion = EventoPresentaciones::create([
            'referencia_archivo' => $rutaRelativa,
            'nombre' => $nombreArchivo,
            'evento_id' => $evento->id,
        ]);

        // Puedes enviar la referencia del archivo como un parámetro en la redirección
        //return redirect()->route('eventos.index', ['referenciaArchivo' => $presentacion->referencia_archivo])->with('success', 'Presentación subida exitosamente.');
        return redirect()->route('eventos.index')->with('success', 'Presentación subida exitosamente.');
    }

    public function guardarReferenciaArchivo(Request $request)
    {
        $referenciaArchivo = $request->input('referenciaArchivo');

        // Guardar la referencia del archivo en la sesión
        session(['referenciaArchivo' => $referenciaArchivo]);

        return response()->json(['success' => true]);
    }

}
