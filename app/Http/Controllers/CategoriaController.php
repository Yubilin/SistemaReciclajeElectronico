<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    private const CAMPOS = [
        'nombre' => ['label' => 'Nombre', 'type' => 'text'],
        'descripcion' => ['label' => 'Descripción', 'type' => 'text'],
    ];

    public function index(): View
    {
        $registros = Categoria::query()->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Categorías',
            'ruta' => 'categorias',
            'campos' => self::CAMPOS,
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear categoría',
            'ruta' => 'categorias',
            'campos' => self::CAMPOS,
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
        ]);

        Categoria::create($datos);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle de la categoría',
            'ruta' => 'categorias',
            'campos' => self::CAMPOS,
            'registro' => $categoria,
        ]);
    }

    public function edit(Categoria $categoria): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar categoría',
            'ruta' => 'categorias',
            'campos' => self::CAMPOS,
            'registro' => $categoria,
        ]);
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
        ]);

        $categoria->update($datos);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
