<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\PresentadorController;
use App\Http\Controllers\PresentacionesController;

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

/* ---------------- Ruta de Eventos ---------------- */
// ruta de index
Route::group(['middleware' => ['web']], function () {
  Route::get('/index', [EventosController::class, 'misEventos'])->name('eventos.index');
});

// subir presentaciones
Route::get('/eventos/{idEvento}/subir-presentacion', [EventosController::class, 'subirPresentacion'])->name('eventos.subirPresentacion');

// guardar-presentaciones
Route::post('/eventos/{idEvento}/guardarPresentacion', [EventosController::class, 'guardarPresentacion'])->name('eventos.guardarPresentacion');

// obtener presentaciones de un evento
Route::get('/presentaciones/{idEvento}', [PresentacionesController::class, 'getPresentacionesPorEvento'])->name('presentaciones.evento');
/* ------------------------------------------------- */

/* ---------------- Rutas de Presentador ---------------- */
//pestaña presentador con la presentación seleccionada
Route::get('/presentador/{idevento_presentacion}', [PresentadorController::class, 'presentador'])->name('presentador');

//pestaña presentación con la presentación seleccionada
Route::get('/presentacion/{referencia_Archivo}', [PresentadorController::class, 'presentacion'])->name('presentacion');

//volver de la pestaña presentador
Route::get('/volver', [PresentadorController::class, 'volver'])->name('volver');
/* ------------------------------------------------- */