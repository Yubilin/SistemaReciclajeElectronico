<?php

namespace App\Http\Controllers;

use App\Models\materialRecibido;
use App\Models\recuperacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Support\Catalogo;

class RecuperacionController extends Controller
{
    private function campos(): array
    {
        return [
            'fecha' => ['label' => 'Fecha', 'type' => 'date'],
            'observaciones' => ['label' => 'Observaciones', 'type' => 'text'],
            'resultado' => ['label' => 'Resultado', 'type' => 'select', 'options' => Catalogo::opciones('resultados')],
            'material_recibido_id' => [
                'label' => 'Material recibido',
                'type' => 'select',
                'options' => materialRecibido::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'materialRecibido.nombre',
            ],
        ];
    }

    public function index(): View
    {
        $registros = recuperacion::query()->with('materialRecibido')->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Recuperaciones',
            'ruta' => 'recuperaciones',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear recuperación',
            'ruta' => 'recuperaciones',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'observaciones' => ['required', 'string', 'max:255'],
            'resultado' => ['required', Catalogo::regla('resultados')],
            'material_recibido_id' => ['required', 'integer', 'exists:material_recibidos,id'],
        ]);

        recuperacion::create($datos);

        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación creada correctamente.');
    }

    public function show(recuperacion $recuperacion): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle de la recuperación',
            'ruta' => 'recuperaciones',
            'campos' => $this->campos(),
            'registro' => $recuperacion->load('materialRecibido'),
        ]);
    }

    public function edit(recuperacion $recuperacion): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar recuperación',
            'ruta' => 'recuperaciones',
            'campos' => $this->campos(),
            'registro' => $recuperacion,
        ]);
    }

    public function update(Request $request, recuperacion $recuperacion): RedirectResponse
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'observaciones' => ['required', 'string', 'max:255'],
            'resultado' => ['required', Catalogo::regla('resultados')],
            'material_recibido_id' => ['required', 'integer', 'exists:material_recibidos,id'],
        ]);

        $recuperacion->update($datos);

        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación actualizada correctamente.');
    }

    public function destroy(recuperacion $recuperacion): RedirectResponse
    {
        $recuperacion->delete();

        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación eliminada correctamente.');
    }
}
