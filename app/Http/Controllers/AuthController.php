<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Puedes agregar aquí la lógica de autenticación con Auth0

        // Redirige a la página de inicio después del inicio de sesión
        return redirect('/index');
    }
}
