<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Auth0\SDK\Auth0;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    // Método para mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('login'); // Reemplaza 'login' con la ruta correcta de tu vista
    }

    // Método para redirigir al inicio de sesión de Auth0

    public function redirectToAuth0(Request $request)
    {
        $auth0 = new Auth0([
            'domain' => $_ENV['AUTH0_DOMAIN'],
            'clientId' => $_ENV['AUTH0_CLIENT_ID'],
            'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
            'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
            'redirectUri' => $_ENV['AUTH0_REDIRECT_URI'],
        ]);

        $authUrl = $auth0->login();

        return redirect()->away($authUrl);
    }

    public function handleAuth0Callback(Request $request)
    {
        try {
            $auth0 = new Auth0([
                'domain' => $_ENV['AUTH0_DOMAIN'],
                'clientId' => $_ENV['AUTH0_CLIENT_ID'],
                'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
                'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
                'redirectUri' => $_ENV['AUTH0_REDIRECT_URI'],
            ]);

            // Obtén la información del usuario de Auth0
            $userInfo = $auth0->getUser();

            // Loguea la información del usuario (opcional, para debugging)
            Log::info(json_encode($userInfo));
            Log::info('estoy en la linea 54');
            Log::info(json_encode($request->all()));

            $info = $auth0->getCredentials();

            // Loguea la información del usuario (opcional, para debugging)
            Log::info($info);
            Log::info('estoy en la linea 60');

            // Busca al usuario en la base de datos por dirección de correo electrónico
            $user = User::where('email', $userInfo['email'])->first();

            // Si el usuario no existe, crea uno nuevo
            if (!$user) {
                $user = User::create([
                    'email' => $userInfo['email'],
                    'nombre' => $userInfo['nombre'], // Asegúrate de ajustar esto según la información que proporciona Auth0
                    // ... otros campos según sea necesario
                ]);
            }

            // Autentica al usuario en Laravel
            Auth::login($user);

            // Personaliza la lógica después de la autenticación exitosa
            return redirect()->route('index'); // Reemplaza 'index' con la ruta correcta de tu página principal
        } catch (\Exception $e) {
            // Loguea el error
            Log::error('Error al obtener información del usuario de Auth0:', ['exception' => $e]);
            // Puedes redirigir al usuario a una página de error
            return redirect()->route('login')->with('error', 'Error al obtener la información del usuario de Auth0.');
        }
    }
}

    /*
    public function handleAuth0Callback(Request $request)
    {
        $auth0 = new Auth0([
            'domain' => $_ENV['AUTH0_DOMAIN'],
            'clientId' => $_ENV['AUTH0_CLIENT_ID'],
            'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
            'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
            'redirectUri' => $_ENV['AUTH0_REDIRECT_URI'],
        ]);

        // Obtén la información del usuario de Auth0
        $userInfo = $auth0->getUser();

        // Si el usuario no existe, crea uno nuevo
        if ($userInfo !== null) {
            // Busca al usuario en la base de datos por dirección de correo electrónico
            $user = User::where('email', $userInfo['email'])->first();

            // Si el usuario no existe, crea uno nuevo
            if (!$user) {
                $user = User::create([
                    'email' => $userInfo['email'],
                    'nombre' => $userInfo['nombre'], // Asegúrate de ajustar esto según la información que proporciona Auth0
                    // ... otros campos según sea necesario
                ]);
            }

            // Autentica al usuario en Laravel
            auth()->login($user); // Utiliza \Auth para referenciar directamente el facade Auth de Laravel

            // Personaliza la lógica después de la autenticación exitosa
            return redirect()->route('index'); // Reemplaza 'index' con la ruta correcta de tu página principal
        } else {
            // Maneja el caso en el que no se obtenga la información del usuario correctamente
            return redirect()->route('login')->with('error', 'Error al obtener la información del usuario de Auth0.');
        }
    }
}
*/