<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventarioApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Inventario::with('componente')->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'cantidadDisponible' => 'required|integer|min:0',
            'cantidadMinima' => 'required|integer|min:0',
            'componente_id' => 'required|exists:componentes,id|unique:inventarios,componente_id',
        ]);

        $inventario = Inventario::create($datos);
        return response()->json($inventario->load('componente'), 201);
    }

    public function show(Inventario $inventario): JsonResponse
    {
        return response()->json($inventario->load('componente'));
    }

    public function update(Request $request, Inventario $inventario): JsonResponse
    {
        $datos = $request->validate([
            'cantidadDisponible' => 'sometimes|integer|min:0',
            'cantidadMinima' => 'sometimes|integer|min:0',
            'componente_id' => [
                'sometimes',
                'exists:componentes,id',
                Rule::unique('inventarios', 'componente_id')->ignore($inventario->id),
            ],
        ]);

        $inventario->update($datos);
        return response()->json($inventario->load('componente'));
    }

    public function destroy(Inventario $inventario): JsonResponse
    {
        $inventario->delete();
        return response()->json(null, 204);
    }
}