<?php

use App\Http\Controllers\Api\UsuarioApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\EntreganteApiController;
use App\Http\Controllers\Api\RecepcionApiController;
use App\Http\Controllers\Api\MaterialRecibidoApiController;
use App\Http\Controllers\Api\RecuperacionApiController;
use App\Http\Controllers\Api\ComponenteApiController;
use App\Http\Controllers\Api\InventarioApiController;
use App\Http\Controllers\Api\AsignacionApiController;
use Illuminate\Support\Facades\Route;

// Los nombres llevan el prefijo "api." para no colisionar con las rutas web
// (p. ej. route('usuarios.store') debe apuntar al controlador web, no a la API).
Route::name('api.')->group(function () {
    Route::apiResource('usuarios', UsuarioApiController::class);
    Route::apiResource('categorias', CategoriaApiController::class);
    Route::apiResource('entregantes', EntreganteApiController::class);
    Route::apiResource('recepciones', RecepcionApiController::class);
    Route::apiResource('materiales-recibidos', MaterialRecibidoApiController::class)
        ->parameters(['materiales-recibidos' => 'materialRecibido']);
    Route::apiResource('recuperaciones', RecuperacionApiController::class)
        ->parameters(['recuperaciones' => 'recuperacion']);
    Route::apiResource('componentes', ComponenteApiController::class)
        ->parameters(['componentes' => 'componente']);
    Route::apiResource('inventarios', InventarioApiController::class);
    Route::apiResource('asignaciones', AsignacionApiController::class);
});
