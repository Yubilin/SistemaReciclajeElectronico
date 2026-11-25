<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\MaterialRecibido;
use App\Models\Recepcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialRecibidoController extends Controller
{
    private function campos(): array
    {
        return [
            'nombre' => ['label' => 'Nombre', 'type' => 'text'],
            'tipo' => ['label' => 'Tipo', 'type' => 'text'],
            'marca' => ['label' => 'Marca', 'type' => 'text'],
            'modelo' => ['label' => 'Modelo', 'type' => 'text'],
            'descripcion' => ['label' => 'Descripción', 'type' => 'text'],
            'cantidad' => ['label' => 'Cantidad', 'type' => 'number'],
            'categoria_id' => [
                'label' => 'Categoría',
                'type' => 'select',
                'options' => Categoria::query()->orderBy('nombre')->pluck('nombre', 'id'),
                'relation' => 'categoria.nombre',
            ],
            'recepcion_id' => [
                'label' => 'Recepción',
                'type' => 'select',
                'options' => Recepcion::query()->orderByDesc('fecha')->pluck('id', 'id'),
                'relation' => 'recepcion.id',
            ],
        ];
    }

    public function index(): View
    {
        $registros = MaterialRecibido::query()->with(['categoria', 'recepcion'])->orderBy('id')->paginate(10);

        return view('recursos.index', [
            'registros' => $registros,
            'titulo' => 'Materiales recibidos',
            'ruta' => 'materiales-recibidos',
            'campos' => $this->campos(),
        ]);
    }

    public function create(): View
    {
        return view('recursos.form', [
            'titulo' => 'Crear material recibido',
            'ruta' => 'materiales-recibidos',
            'campos' => $this->campos(),
            'registro' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'recepcion_id' => ['required', 'integer', 'exists:recepcions,id'],
        ]);

        MaterialRecibido::create($datos);

        return redirect()->route('materiales-recibidos.index')->with('success', 'Material recibido creado correctamente.');
    }

    public function show(MaterialRecibido $materialRecibido): View
    {
        return view('recursos.show', [
            'titulo' => 'Detalle del material recibido',
            'ruta' => 'materiales-recibidos',
            'campos' => $this->campos(),
            'registro' => $materialRecibido->load(['categoria', 'recepcion']),
        ]);
    }

    public function edit(MaterialRecibido $materialRecibido): View
    {
        return view('recursos.form', [
            'titulo' => 'Editar material recibido',
            'ruta' => 'materiales-recibidos',
            'campos' => $this->campos(),
            'registro' => $materialRecibido,
        ]);
    }

    public function update(Request $request, MaterialRecibido $materialRecibido): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'recepcion_id' => ['required', 'integer', 'exists:recepcions,id'],
        ]);

        $materialRecibido->update($datos);

        return redirect()->route('materiales-recibidos.index')->with('success', 'Material recibido actualizado correctamente.');
    }

    public function destroy(MaterialRecibido $materialRecibido): RedirectResponse
    {
        $materialRecibido->delete();

        return redirect()->route('materiales-recibidos.index')->with('success', 'Material recibido eliminado correctamente.');
    }
}
