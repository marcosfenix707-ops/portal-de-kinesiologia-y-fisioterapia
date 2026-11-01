<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// ---------- Portal público ----------
Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'inicio')->name('inicio');
    Route::get('/la-carrera', 'carrera')->name('carrera.index');
    Route::get('/la-carrera/{contenido:clave}', 'seccion')->name('carrera.seccion');
    Route::get('/noticias', 'noticias')->name('noticias.index');
    Route::get('/noticias/{noticia}', 'noticia')->name('noticias.show');
    Route::get('/documentos', 'documentos')->name('documentos.index');
    Route::get('/documentos/{documento}', 'documento')->name('documentos.show');
    Route::get('/documentos/{documento}/archivo', 'archivo')->name('documentos.archivo');
    Route::get('/documentos/{documento}/descargar', 'descargar')->name('documentos.descargar');
    Route::get('/buscar', 'buscar')->name('buscar');
    Route::get('/preinscripcion', 'preinscripcion')->name('preinscripcion');
    Route::post('/preinscripcion', 'guardarPreinscripcion')->middleware('throttle:5,10')->name('preinscripcion.guardar');
    Route::get('/contacto', 'contacto')->name('contacto');
    Route::post('/contacto', 'guardarConsulta')->middleware('throttle:5,10')->name('contacto.guardar');
});

// ---------- Acceso ----------
Route::middleware('guest')->group(function () {
    Route::get('/acceso', [LoginController::class, 'formulario'])->name('login');
    Route::post('/acceso', [LoginController::class, 'ingresar'])->name('login.ingresar');
});
Route::post('/salir', [LoginController::class, 'salir'])->middleware('auth')->name('logout');

// ---------- Panel de administración ----------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'rol:administrador,personal'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('documentos', Admin\DocumentoController::class)->except('show');
    Route::resource('categorias', Admin\CategoriaController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('noticias', Admin\NoticiaController::class)->except('show');
    Route::resource('contenidos', Admin\ContenidoController::class)->only(['index', 'edit', 'update']);
    Route::resource('preinscripciones', Admin\PreinscripcionController::class)
        ->only(['index', 'show', 'update', 'destroy'])->parameters(['preinscripciones' => 'preinscripcion']);
    Route::resource('consultas', Admin\ConsultaController::class)->only(['index', 'update', 'destroy']);

    // Solo el administrador (dirección de carrera)
    Route::middleware('rol:administrador')->group(function () {
        Route::resource('usuarios', Admin\UsuarioController::class)->except('show')->parameters(['usuarios' => 'usuario']);
        Route::get('respaldos', [Admin\RespaldoController::class, 'index'])->name('respaldos.index');
        Route::post('respaldos', [Admin\RespaldoController::class, 'store'])->name('respaldos.store');
        Route::get('respaldos/{archivo}', [Admin\RespaldoController::class, 'descargar'])->name('respaldos.descargar');
    });
});
