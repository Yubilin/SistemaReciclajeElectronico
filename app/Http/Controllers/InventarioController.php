<?php

namespace App\Http\Controllers;

use App\Models\Componentes;
use App\Models\Inventario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InventarioController extends Controller
{
    private function campos(): array
    {
        return [
            'cantidadDisponible' => ['label' => 'Cantidad disponible', 'type' => 'number'],
            'cantidadMinima' => ['label' => 'Cantidad mínima', 'type' => 'number'],
            'componente_id' => [
                'label' => 'Componente',
                'type' => 'select',
                'options' => Componentes::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'componente.nombre',
            ],
        ];
    }

    public function index(): View
    {
        $registros = Inventario::query()->with('componente')->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Inventarios',
            'ruta' => 'inventarios',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear inventario',
            'ruta' => 'inventarios',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'cantidadDisponible' => ['required', 'integer', 'min:0'],
            'cantidadMinima' => ['required', 'integer', 'min:0'],
            'componente_id' => ['required', 'integer', 'exists:componentes,id', 'unique:inventarios,componente_id'],
        ]);

        Inventario::create($datos);

        return redirect()->route('inventarios.index')->with('success', 'Inventario creado correctamente.');
    }

    public function show(Inventario $inventario): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle del inventario',
            'ruta' => 'inventarios',
            'campos' => $this->campos(),
            'registro' => $inventario->load('componente'),
        ]);
    }

    public function edit(Inventario $inventario): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar inventario',
            'ruta' => 'inventarios',
            'campos' => $this->campos(),
            'registro' => $inventario,
        ]);
    }

    public function update(Request $request, Inventario $inventario): RedirectResponse
    {
        $datos = $request->validate([
            'cantidadDisponible' => ['required', 'integer', 'min:0'],
            'cantidadMinima' => ['required', 'integer', 'min:0'],
            'componente_id' => [
                'required',
                'integer',
                'exists:componentes,id',
                Rule::unique('inventarios', 'componente_id')->ignore($inventario->id),
            ],
        ]);

        $inventario->update($datos);

        return redirect()->route('inventarios.index')->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy(Inventario $inventario): RedirectResponse
    {
        $inventario->delete();

        return redirect()->route('inventarios.index')->with('success', 'Inventario eliminado correctamente.');
    }
}
