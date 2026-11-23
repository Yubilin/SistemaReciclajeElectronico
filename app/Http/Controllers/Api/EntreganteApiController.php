<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entregante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EntreganteApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Entregante::paginate(10));
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $entregante = Entregante::create($datos);
        return response()->json($entregante, 201);
    }

    public function show(Entregante $entregante): JsonResponse
    {
        return response()->json($entregante->load('recepciones'));
    }

    public function update(Request $request, Entregante $entregante): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'ci' => 'sometimes|string|max:255',
            'telefono' => 'sometimes|string|max:255',
            'direccion' => 'sometimes|string|max:255',
        ]);

        $entregante->update($datos);
        return response()->json($entregante);
    }

    public function destroy(Entregante $entregante): JsonResponse
    {
        $entregante->delete();
        return response()->json(null, 204);
    }
}