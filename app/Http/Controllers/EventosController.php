<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventosController extends Controller
{
    public function tablaEventos(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $usuario = $request->user();

        // Loguear información del usuario autenticado
        Log::info('Usuario autenticado de Auth0:',
            ['user' => $user],
        );
        Log::info(
            'Usuario autenticado por req:',
            ['user' => $usuario],
        );
        

        // Verificar si el usuario existe en la base de datos
        // $usuarioDB = DB::table('usuarios')->where('email', $user->email)->first();
        /*
        if (!$usuarioDB) {
            // El usuario no existe en la base de datos, puedes tomar la acción adecuada
            return redirect()->route('login');
        }

        // Usuario existe, ahora obtén el ID de Auth0 y ejecuta la consulta
        $token = $usuarioDB->idAuth0;
*/
        $eventos = [
            (object)[
                'nombre_evento' => 'Evento 1',
                'fecha' => '2023-11-20',
                'descripcion' => 'Descripción del evento 1',
                'id_evento' => 1,
            ],
            (object)[
                'nombre_evento' => 'Evento 2',
                'fecha' => '2023-11-21',
                'descripcion' => 'Descripción del evento 2',
                'id_evento' => 2,
            ],
        ];
        /*
         DB::select("SELECT e.nombre AS nombre_evento, e.fecha AS fecha, e.descripcion AS descripcion, e.id AS id_evento
            FROM evento e
            JOIN asistente a ON e.id = a.evento_id
            JOIN rol r ON a.rol_id = r.id
            JOIN usuario u ON a.participante_id = u.id
            WHERE e.tipo_evento = 'Formal' AND r.nombre = 'presentador' AND u.idAuth0 = :token", ['token' => $token]);
        */
        return view('index', compact('eventos'));
    }

    public function subirPresentacion($idEvento)
    {
        //return redirect()->route('eventos.tabla'); // Redirige a la página de eventos después de subir la presentación
    }

    public function verPresentacion($idEvento)
    {

        //return redirect()->route('eventos.tabla'); // Redirige a la página de eventos después de ver la presentación
    }
}
