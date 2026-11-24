<?php

namespace App\Http\Controllers;

use App\Models\asignacion;
use App\Models\materialRecibido;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Support\Catalogo;

class AsignacionController extends Controller
{
    private function campos(): array
    {
        return [
            'numeroTurno' => ['label' => 'Número de turno', 'type' => 'number'],
            'fechaInicio' => ['label' => 'Fecha de inicio', 'type' => 'date'],
            'fechaFinalizacion' => ['label' => 'Fecha de finalización', 'type' => 'date'],
            'prioridad' => ['label' => 'Prioridad', 'type' => 'select', 'options' => Catalogo::opciones('prioridades')],
            'estado' => ['label' => 'Estado', 'type' => 'select', 'options' => Catalogo::opciones('estados.asignaciones')],
            'observacion' => ['label' => 'Observación', 'type' => 'text'],
            'usuario_id' => [
                'label' => 'Usuario',
                'type' => 'select',
                'options' => Usuario::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'usuario.nombre',
            ],
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
        $registros = asignacion::query()->with(['usuario', 'materialRecibido'])->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Asignaciones',
            'ruta' => 'asignaciones',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear asignación',
            'ruta' => 'asignaciones',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'numeroTurno' => ['required', 'integer', 'min:0'],
            'fechaInicio' => ['required', 'date'],
            'fechaFinalizacion' => ['required', 'date', 'after_or_equal:fechaInicio'],
            'prioridad' => ['required', Catalogo::regla('prioridades')],
            'estado' => ['required', Catalogo::regla('estados.asignaciones')],
            'observacion' => ['required', 'string', 'max:255'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'material_recibido_id' => ['required', 'integer', 'exists:material_recibidos,id'],
        ]);

        asignacion::create($datos);

        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada correctamente.');
    }

    public function show(asignacion $asignacion): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle de la asignación',
            'ruta' => 'asignaciones',
            'campos' => $this->campos(),
            'registro' => $asignacion->load(['usuario', 'materialRecibido']),
        ]);
    }

    public function edit(asignacion $asignacion): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar asignación',
            'ruta' => 'asignaciones',
            'campos' => $this->campos(),
            'registro' => $asignacion,
        ]);
    }

    public function update(Request $request, asignacion $asignacion): RedirectResponse
    {
        $datos = $request->validate([
            'numeroTurno' => ['required', 'integer', 'min:0'],
            'fechaInicio' => ['required', 'date'],
            'fechaFinalizacion' => ['required', 'date', 'after_or_equal:fechaInicio'],
            'prioridad' => ['required', Catalogo::regla('prioridades')],
            'estado' => ['required', Catalogo::regla('estados.asignaciones')],
            'observacion' => ['required', 'string', 'max:255'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'material_recibido_id' => ['required', 'integer', 'exists:material_recibidos,id'],
        ]);

        $asignacion->update($datos);

        return redirect()->route('asignaciones.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(asignacion $asignacion): RedirectResponse
    {
        $asignacion->delete();

        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
