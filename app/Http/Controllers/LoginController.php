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
use Auth0\Laravel\Contract\Auth0UserRepository;
use Auth0\Laravel\Contract\Auth0UserRepository as Auth0UserRepositoryContract;
use Auth0\Laravel\Guard\StatelessJwtGuard;
use Auth0\Laravel\Guard\Guard;
use Auth0\Laravel\Entities\CredentialEntity;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $model = Usuario::class;
    protected $redirectTo = '/index';

    public function showLoginForm()
    {
        return view('login');
    }

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

    public function login()
    {
        $auth0 = $this->auth0();

        // getExchangeParameters() can be used on your callback URL to verify all the necessary parameters are present for post-authentication code exchange.
        if ($auth0->getExchangeParameters()) {
            // If they're present, we should perform the code exchange.
            $auth0->exchange();
        }
        $credentials = $auth0->getCredentials();
        $userInfo = $auth0->getUser();
        $lol = $auth0->getAccessToken();

        $user = Usuario::firstOrCreate(
            ['email' => $userInfo['email']],
            [
                'nombre' => $userInfo['given_name'],
                'apellido' => $userInfo['family_name'],
                'nombre_usuario' => $userInfo['nickname'],
                'idAuth0' => $userInfo['sub'],
                'foto_perfil_id' => 1,
            ]
        );

        // Crear una sesión personalizada
        $this->createCustomSession($userInfo);

        Log::info('Antes de autenticar al usuario');
        $auth0->login($user);
        Log::info('Después de autenticar al usuario');
        Log::info($auth0->login());

        session(['auth0_user' => $userInfo]);
        session(['usuario_laravel' => $user]);

        return redirect()->route('eventos.index');
    }

    public function logout()
    {
        $auth0 = $this->auth0();

        // Cerrar la sesión de Auth0
        $auth0->logout();

        // Cerrar la sesión de Laravel
        Auth::logout();

        Session::flush();

        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('login');
    }

    private function createCustomSession($userInfo)
    {
        // Almacenar la información del usuario en la sesión personalizada
        Session::put('user.idAuth0', $userInfo['sub']);
        Session::put('user.email', $userInfo['email']);
        // ... Puedes almacenar más información según tus necesidades

        // También puedes almacenar el token de acceso si es necesario
        $auth0 = $this->auth0();
        $accessToken = $auth0->getAccessToken();
        Session::put('auth.access_token', $accessToken);
    }
}