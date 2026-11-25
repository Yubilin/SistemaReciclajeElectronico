<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComponentesController;
use App\Http\Controllers\EntreganteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MaterialRecibidoController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\RecuperacionController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

use App\Models\Usuario;
use App\Models\Entregante;
use App\Models\Categoria;
use App\Models\Recepcion;
use App\Models\MaterialRecibido;

Route::get('/', function () {
    return view('welcome', [
        'usuarios' => Usuario::count(),
        'entregantes' => Entregante::count(),
        'categorias' => Categoria::count(),
        'recepciones' => Recepcion::count(),
        'materiales' => MaterialRecibido::count(),
        'categoriasLista' => Categoria::latest()->take(5)->get(),
        'entregantesLista' => Entregante::latest()->take(5)->get(),
        'recepcionesLista' => Recepcion::with('entregante')->latest()->take(5)->get(),
    ]);
});

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