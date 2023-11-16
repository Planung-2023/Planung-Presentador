<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth0Controller extends Controller
{
    public function login()
    {
        return app(LoginController::class)->login();
    }

    public function logout()
    {
        return app(LoginController::class)->logout();
    }

    public function callback(Request $request)
    {
        app(LoginController::class)->callback();
        return redirect()->to('/');
    }
}
