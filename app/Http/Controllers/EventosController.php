<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Evento;
use App\Models\Usuario;

class EventosController extends Controller
{
    public function misEventos()
    {
        // Obtener el usuario autenticado actualmente
        $userInfo = session('auth0_user');
        $user = session('usuario_laravel');

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

            // Pasar los eventos a la vista 'index'
            
        }
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
