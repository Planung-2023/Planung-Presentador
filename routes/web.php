<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventosController;

// Ruta de inicio de sesión personalizado
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta de Auth0 para iniciar sesión
Route::get('/auth0/login', [LoginController::class, 'redirectToAuth0'])->name('auth0.login');

// Ruta de retorno después de la autenticación exitosa en Auth0
Route::get('/auth0/callback', [LoginController::class, 'handleAuth0Callback']);

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas que requieren autenticación de Auth0
Route::group(['middleware' => ['auth']], function () {
  Route::get('/index', [HomeController::class, 'index'])->name('index');
  //tabla eventos
  Route::get('/index', [EventosController::class, 'tablaEventos'])->name('index');
  Route::post('/subir-presentacion/{idEvento}', [EventosController::class, 'subirPresentacion'])->name('eventos.subirPresentacion');
  Route::get('/ver-presentacion/{idEvento}', [EventosController::class, 'verPresentacion'])->name('eventos.verPresentacion');
});



//Route::get('/index', [HomeController::class, 'index'])->name('index');
