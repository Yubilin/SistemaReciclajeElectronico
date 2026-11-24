<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Componentes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Support\Catalogo;

class ComponenteApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Componentes::with(['recuperacion', 'inventario'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'estado' => ['required', Catalogo::regla('estados.componentes')],
            'recuperacion_id' => 'required|exists:recuperacions,id',
        ]);

        $componente = Componentes::create($datos);
        return response()->json($componente->load('recuperacion'), 201);
    }

    public function show(Componentes $componente): JsonResponse
    {
        return response()->json($componente->load(['recuperacion', 'inventario']));
    }

    public function update(Request $request, Componentes $componente): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:255',
            'cantidad' => 'sometimes|integer|min:0',
            'estado' => ['sometimes', Catalogo::regla('estados.componentes')],
            'recuperacion_id' => 'sometimes|exists:recuperacions,id',
        ]);

        $componente->update($datos);
        return response()->json($componente->load('recuperacion'));
    }

    public function destroy(Componentes $componente): JsonResponse
    {
        $componente->delete();
        return response()->json(null, 204);
    }
}