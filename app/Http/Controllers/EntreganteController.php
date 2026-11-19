<?php

namespace App\Http\Controllers;

use App\Models\Entregante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntreganteController extends Controller
{
    private const CAMPOS = [
        'nombre' => ['label' => 'Nombre', 'type' => 'text'],
        'apellido' => ['label' => 'Apellido', 'type' => 'text'],
        'ci' => ['label' => 'Cédula', 'type' => 'text'],
        'telefono' => ['label' => 'Teléfono', 'type' => 'text'],
        'direccion' => ['label' => 'Dirección', 'type' => 'text'],
    ];

    public function index(): View
    {
        $registros = Entregante::query()->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Entregantes',
            'ruta' => 'entregantes',
            'campos' => self::CAMPOS,
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear entregante',
            'ruta' => 'entregantes',
            'campos' => self::CAMPOS,
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'ci' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
        ]);

        Entregante::create($datos);

        return redirect()->route('entregantes.index')->with('success', 'Entregante creado correctamente.');
    }

    public function show(Entregante $entregante): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle del entregante',
            'ruta' => 'entregantes',
            'campos' => self::CAMPOS,
            'registro' => $entregante,
        ]);
    }

    public function edit(Entregante $entregante): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar entregante',
            'ruta' => 'entregantes',
            'campos' => self::CAMPOS,
            'registro' => $entregante,
        ]);
    }

    public function update(Request $request, Entregante $entregante): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'ci' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
        ]);

        $entregante->update($datos);

        return redirect()->route('entregantes.index')->with('success', 'Entregante actualizado correctamente.');
    }

    public function destroy(Entregante $entregante): RedirectResponse
    {
        $entregante->delete();

        return redirect()->route('entregantes.index')->with('success', 'Entregante eliminado correctamente.');
    }
}
