<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\EventoPresentaciones;
use App\Models\FotoPerfil;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventosController extends Controller
{
    public function misEventos()
    {
        $userInfo = session('auth0_user');
        $user = session('usuario_laravel');

        if($userInfo == null){
            return redirect()->route('login');
        }

        $usuario = Usuario::where('email', $user['email'])->first();
        $nombreUsuario = $usuario['nombre_usuario'];

        $fotoPerfil = FotoPerfil::where('id', $usuario['foto_perfil_id'])->first();
        $fotoPerfilUsuario = $fotoPerfil['nombre'];

        $fechaActual = now();

        if ($usuario) {

            $eventos = Evento::select(
                'evento.nombre',
                'evento.fecha',
                'evento.descripcion',
                'evento.id',
                DB::raw('COUNT(DISTINCT evento_presentacion.idevento_presentacion) as cantidad_presentaciones')
            )
            ->join('asistente', 'evento.id', '=', 'asistente.evento_id')
            ->join('usuario', 'asistente.participante_id', '=', 'usuario.id')
            ->leftJoin('evento_presentacion', 'evento.id', '=', 'evento_presentacion.evento_id')
            ->where('evento.tipo_evento', 'Formal')
            ->where('usuario.id', $usuario->id)
            ->where('evento.fecha', '>=', $fechaActual)
            ->groupBy('evento.id', 'evento.nombre', 'evento.fecha', 'evento.descripcion')
            ->get();

            $presentaciones = EventoPresentaciones::all();

            return view('index', compact('eventos', 'presentaciones', 'nombreUsuario', 'fotoPerfilUsuario', 'usuario'));
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
            'pdf' => 'required|mimes:pdf|max:10240',
        ]);

        $idEvento = $request->input('idEvento');
        $evento = Evento::findOrFail($idEvento);

        // Subir el archivo PDF
        $pdf = $request->file('pdf');
        $nombreOriginal = $pdf->getClientOriginalName();

        $nombreArchivo = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) . '.' . $pdf->getClientOriginalExtension();

        // Verificar si ya existe una presentación con el mismo nombre para el evento
        $presentacionExistente = EventoPresentaciones::where('nombre', $nombreArchivo)
            ->where('evento_id', $evento->id)
            ->first();

        if ($presentacionExistente) {
            return redirect()->route('eventos.index')->with('error', 'Ya existe una presentación con este nombre para este evento.');
        }

        // Mover el archivo a la carpeta de almacenamiento con un nombre único
        $rutaArchivo = $pdf->storeAs('archivos', $nombreArchivo, 'public');

        // Deshabilitar timestamps
        EventoPresentaciones::flushEventListeners();

        // Guardar la información en la base de datos sin timestamps
        $presentacion = EventoPresentaciones::create([
            'referencia_archivo' => Storage::url($rutaArchivo),
            'nombre' => $nombreArchivo,
            'evento_id' => $evento->id,
        ]);

        return redirect()->route('eventos.index');
    }

}
