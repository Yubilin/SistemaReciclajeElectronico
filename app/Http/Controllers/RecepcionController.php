<?php

namespace App\Http\Controllers;

use App\Models\Entregante;
use App\Models\Recepcion;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecepcionController extends Controller
{
    private function campos(): array
    {
        return [
            'fecha' => ['label' => 'Fecha', 'type' => 'date'],
            'observaciones' => ['label' => 'Observaciones', 'type' => 'text'],
            'estado' => ['label' => 'Estado', 'type' => 'text'],
            'usuario_id' => [
                'label' => 'Usuario',
                'type' => 'select',
                'options' => Usuario::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'usuario.nombre',
            ],
            'entregante_id' => [
                'label' => 'Entregante',
                'type' => 'select',
                'options' => Entregante::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'entregante.nombre',
            ],
        ];
    }

    public function index(): View
    {
        $registros = Recepcion::query()->with(['usuario', 'entregante'])->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Recepciones',
            'ruta' => 'recepciones',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear recepción',
            'ruta' => 'recepciones',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'observaciones' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'entregante_id' => ['required', 'integer', 'exists:entregantes,id'],
        ]);

        Recepcion::create($datos);

        return redirect()->route('recepciones.index')->with('success', 'Recepción creada correctamente.');
    }

    public function show(Recepcion $recepcion): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle de la recepción',
            'ruta' => 'recepciones',
            'campos' => $this->campos(),
            'registro' => $recepcion->load(['usuario', 'entregante']),
        ]);
    }

    public function edit(Recepcion $recepcion): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar recepción',
            'ruta' => 'recepciones',
            'campos' => $this->campos(),
            'registro' => $recepcion,
        ]);
    }

    public function update(Request $request, Recepcion $recepcion): RedirectResponse
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'observaciones' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'entregante_id' => ['required', 'integer', 'exists:entregantes,id'],
        ]);

        $recepcion->update($datos);

        return redirect()->route('recepciones.index')->with('success', 'Recepción actualizada correctamente.');
    }

    public function destroy(Recepcion $recepcion): RedirectResponse
    {
        $recepcion->delete();

        return redirect()->route('recepciones.index')->with('success', 'Recepción eliminada correctamente.');
    }
}
