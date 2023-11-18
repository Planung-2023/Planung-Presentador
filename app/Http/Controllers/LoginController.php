<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Auth0\SDK\Auth0;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Auth0\Laravel\Entities\Auth0User;

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

            $userInfo = $auth0->getUser();

            //$user = Usuario::where('email', $userInfo['email'])->first();
// ----------------------------------------------------- Pruebas 17/11
//
            Log::info(json_encode($session));
            Log::info(json_encode($userInfo));
            //$user = Usuario::where('email', $userInfo['email'])->first();
            $user = Usuario::where('idAuth0', $userInfo['sub'])->first();
            //dd($session);
           // dd($user);
            //Log::info($user);

            //dd($userInfo);//SEGUILA AGUS

            $usuario = $userInfo['sub'];
            Log::info($usuario);
            Log::info($user);


           if($user !== null) {
                Auth::login($user);
           }

// 
//------------------------------------------*/

            return redirect()->route('index');
        } catch (\Exception $e) {
            // Loguea el error
            Log::error($e->getMessage());
            // Puedes redirigir al usuario a una página de error
            return redirect()->route('index');
            //return redirect()->route('login')->with('error', 'Error al obtener la información del usuario de Auth0.');
        }
    }

    public function logout()
    {
        $auth0 = $this->auth0();

        // Cerrar la sesión de Auth0
        $auth0->logout();

        // Cerrar la sesión de Laravel
        Auth::logout();

        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('login');
    }

}