<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\PresentadorController;


/* ---------------- Rutas de Login ---------------- */
// Ruta de inicio de sesión personalizado
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta de Auth0 para iniciar sesión
Route::get('/auth0/login', [LoginController::class, 'redirectToAuth0'])->name('auth0.login');

// Ruta de retorno después de la autenticación exitosa en Auth0
Route::get('/auth0/callback', [LoginController::class, 'login']);

// Ruta para cerrar sesión
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
/* ------------------------------------------------ */

/* ---------------- Rutas de Eventos/Presentaciones ---------------- */
Route::group(['middleware' => ['web']], function () {
  Route::get('/index', [EventosController::class, 'misEventos'])->name('eventos.index');
});

// subir-guardar presentaciones
Route::get('/eventos/{idEvento}/subir-presentacion', [EventosController::class, 'subirPresentacion'])->name('eventos.subirPresentacion');
Route::post('/eventos/guardar-presentacion', [EventosController::class, 'guardarPresentacion'])->name('eventos.guardarPresentacion');
//Route::post('/eventos/{idEvento}/guardar-presentacion', [EventosController::class, 'guardarPresentacion'])->name('eventos.guardarPresentacion');

//ver-presentaciones
//Route::get('/eventos/{idEvento}/ver-presentaciones', [EventosController::class, 'verPresentacion'])->name('eventos.verPresentacion');
//Route::get('/mostrar-presentaciones/{eventId}', [EventosController::class, 'mostrarPresentacionesModal']);


Route::post('/guardar-referencia-archivo', [EventosController::class, 'guardarReferenciaArchivo']);


//pestaña presentador
Route::get('/presentador', [PresentadorController::class, 'presentador'])->name('presentador');
//volver de la pestaña presentador
Route::get('/volver', [PresentadorController::class, 'volver'])->name('volver');
//pestaña presentación
Route::get('/presentación', [PresentadorController::class, 'presentacion'])->name('presentacion');