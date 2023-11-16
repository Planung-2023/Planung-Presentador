<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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

    /**
     * @return Auth0
     */
    private function auth0() {
        return new Auth0([
            'domain' => $_ENV['AUTH0_DOMAIN'],
            'clientId' => $_ENV['AUTH0_CLIENT_ID'],
            'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
            'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
            'redirectUri' => env('AUTH0_REDIRECT_URI'),
        ]);
    }

    public function redirectToAuth0(Request $request)
    {
        $auth0 = $this->auth0();

        $authUrl = $auth0->login();

        return redirect()->away($authUrl);
    }

    public function handleAuth0Callback(Request $request)
    {
        //https://auth0.com/docs/get-started/authentication-and-authorization-flow/add-login-auth-code-flow
        try {
            $auth0 = $this->auth0();

            // getExchangeParameters() can be used on your callback URL to verify all the necessary parameters are present for post-authentication code exchange.
            if ($auth0->getExchangeParameters()) {
                // If they're present, we should perform the code exchange.
                $auth0->exchange();
            }

            $session = $auth0->getCredentials();
            dd($session);
            /*$response = Http::withHeaders([
                "content-type" => "application/x-www-form-urlencoded"
            ])->post(env('AUTH0_TOKEN_URL'), [
                'grant_type' => 'authorization_code',
                'client_id' => env('AUTH0_CLIENT_ID'),
                'client_secret' => env('AUTH0_CLIENT_SECRET'),
                'code' => $request->query('code'),
                'redirectUri' => env('AUTH0_REDIRECT_URI'),
            ]);

            dd($response);*/
            /*$auth0 = new Auth0([
                'domain' => $_ENV['AUTH0_DOMAIN'],
                'clientId' => $_ENV['AUTH0_CLIENT_ID'],
                'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
                'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
                'redirectUri' => $_ENV['AUTH0_REDIRECT_URI'],
            ]);

            $userInfo = $auth0->getUser();

            $info = $auth0->getCredentials();


            $user = User::where('email', $userInfo['email'])->first();


            if (!$user) {
                $user = User::create([
                    'email' => $userInfo['email'],
                    'nombre' => $userInfo['nombre'],
                ]);
            }

            Auth::login($user);*/

            return redirect()->route('index');
        } catch (\Exception $e) {
            // Loguea el error
            Log::error($e->getMessage());
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