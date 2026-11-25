<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialRecibido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialRecibidoApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            MaterialRecibido::with(['categoria', 'recepcion'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'recepcion_id' => 'required|exists:recepcions,id',
        ]);

        $material = MaterialRecibido::create($datos);
        return response()->json($material->load(['categoria', 'recepcion']), 201);
    }

    public function show(MaterialRecibido $materialRecibido): JsonResponse
    {
        return response()->json(
            $materialRecibido->load(['categoria', 'recepcion', 'recuperaciones', 'asignaciones'])
        );
    }

    public function update(Request $request, MaterialRecibido $materialRecibido): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'tipo' => 'sometimes|string|max:255',
            'marca' => 'sometimes|string|max:255',
            'modelo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:255',
            'cantidad' => 'sometimes|integer|min:0',
            'categoria_id' => 'sometimes|exists:categorias,id',
            'recepcion_id' => 'sometimes|exists:recepcions,id',
        ]);

        $materialRecibido->update($datos);
        return response()->json($materialRecibido->load(['categoria', 'recepcion']));
    }

    public function destroy(MaterialRecibido $materialRecibido): JsonResponse
    {
        $materialRecibido->delete();
        return response()->json(null, 204);
    }
}