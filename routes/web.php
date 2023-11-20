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
Route::get('/auth0/callback', [LoginController::class, 'login']);

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['web']], function () {
  Route::get('/index', [EventosController::class, 'misEventos'])->name('eventos.index');
  Route::get('/subir-presentacion/{idEvento}', [EventosController::class, 'subirPresentacion'])->name('subir.presentacion');
  Route::get('/ver-presentacion/{idEvento}', [EventosController::class, 'verPresentacion'])->name('ver.presentacion');
});



/*
// Ruta de inicio de sesión personalizado
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta de Auth0 para iniciar sesión
Route::get('/auth0/login', [LoginController::class, 'redirectToAuth0'])->name('auth0.login');

// Ruta de retorno después de la autenticación exitosa en Auth0
Route::get('/auth0/callback', [LoginController::class, 'login']);

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas que requieren autenticación de Auth0
Route::group(['middleware' => ['auth']], function () {
  // Ruta para mostrar los eventos del usuario
  Route::get('/index', [EventosController::class, 'misEventos'])->name('eventos.misEventos');

  // Ruta para la tabla de eventos (si es necesaria)
  Route::get('/tabla-eventos', [EventosController::class, 'tablaEventos'])->name('eventos.tablaEventos');
  Route::post('/subir-presentacion/{idEvento}', [EventosController::class, 'subirPresentacion'])->name('eventos.subirPresentacion');
  Route::get('/ver-presentacion/{idEvento}', [EventosController::class, 'verPresentacion'])->name('eventos.verPresentacion');
});

// Ruta para mostrar el dashboard (cambiar el nombre según sea necesario)
Route::get('/index', [HomeController::class, 'index'])->name('index');

Route::get('/index', [EventosController::class, 'misEventos'])->name('eventos.tablaEventos');
*/