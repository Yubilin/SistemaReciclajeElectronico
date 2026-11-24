<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComponentesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntreganteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MaterialRecibidoController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\RecuperacionController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::resource('usuarios', UsuarioController::class);
Route::resource('componentes', ComponentesController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('entregantes', EntreganteController::class);
Route::resource('recepciones', RecepcionController::class)
    ->parameters(['recepciones' => 'recepcion']);
Route::resource('inventarios', InventarioController::class);
Route::resource('materiales-recibidos', MaterialRecibidoController::class)
    ->parameters(['materiales-recibidos' => 'materialRecibido']);
Route::resource('recuperaciones', RecuperacionController::class)
    ->parameters(['recuperaciones' => 'recuperacion']);
Route::resource('asignaciones', AsignacionController::class)
    ->parameters(['asignaciones' => 'asignacion']);
