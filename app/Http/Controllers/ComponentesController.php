<?php

namespace App\Http\Controllers;

use App\Models\Componentes;
use App\Models\Recuperacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComponentesController extends Controller
{
    private function campos(): array
    {
        return [
            'nombre' => ['label' => 'Nombre', 'type' => 'text'],
            'descripcion' => ['label' => 'Descripción', 'type' => 'text'],
            'cantidad' => ['label' => 'Cantidad', 'type' => 'number'],
            'estado' => ['label' => 'Estado', 'type' => 'text'],
            'recuperacion_id' => [
                'label' => 'Recuperación',
                'type' => 'select',
                'options' => Recuperacion::query()->orderByDesc('fecha')->pluck('fecha', 'id'),
                'relation' => 'recuperacion.fecha',
            ],
        ];
    }

    public function index(): View
    {
        $registros = Componentes::query()->with('recuperacion')->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Componentes',
            'ruta' => 'componentes',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear componente',
            'ruta' => 'componentes',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'estado' => ['required', 'string', 'max:255'],
            'recuperacion_id' => ['required', 'integer', 'exists:recuperacions,id'],
        ]);

        Componentes::create($datos);

        return redirect()->route('componentes.index')->with('success', 'Componente creado correctamente.');
    }

    public function show(Componentes $componente): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle del componente',
            'ruta' => 'componentes',
            'campos' => $this->campos(),
            'registro' => $componente->load('recuperacion'),
        ]);
    }

    public function edit(Componentes $componente): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar componente',
            'ruta' => 'componentes',
            'campos' => $this->campos(),
            'registro' => $componente,
        ]);
    }

    public function update(Request $request, Componentes $componente): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'estado' => ['required', 'string', 'max:255'],
            'recuperacion_id' => ['required', 'integer', 'exists:recuperacions,id'],
        ]);

        $componente->update($datos);

        return redirect()->route('componentes.index')->with('success', 'Componente actualizado correctamente.');
    }

    public function destroy(Componentes $componente): RedirectResponse
    {
        $componente->delete();

        return redirect()->route('componentes.index')->with('success', 'Componente eliminado correctamente.');
    }
}
