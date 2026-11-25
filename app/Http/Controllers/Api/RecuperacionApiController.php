<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recuperacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecuperacionApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Recuperacion::with(['materialRecibido', 'componentes'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'fecha' => 'required|date',
            'observaciones' => 'required|string|max:255',
            'resultado' => 'required|string|max:255',
            'material_recibido_id' => 'required|exists:material_recibidos,id',
        ]);

        $recuperacion = Recuperacion::create($datos);
        return response()->json($recuperacion->load('materialRecibido'), 201);
    }

    public function show(Recuperacion $recuperacion): JsonResponse
    {
        return response()->json($recuperacion->load(['materialRecibido', 'componentes']));
    }

    public function update(Request $request, Recuperacion $recuperacion): JsonResponse
    {
        $datos = $request->validate([
            'fecha' => 'sometimes|date',
            'observaciones' => 'sometimes|string|max:255',
            'resultado' => 'sometimes|string|max:255',
            'material_recibido_id' => 'sometimes|exists:material_recibidos,id',
        ]);

        $recuperacion->update($datos);
        return response()->json($recuperacion->load('materialRecibido'));
    }

    public function destroy(Recuperacion $recuperacion): JsonResponse
    {
        $recuperacion->delete();
        return response()->json(null, 204);
    }
}