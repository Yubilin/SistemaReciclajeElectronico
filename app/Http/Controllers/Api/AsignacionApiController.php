<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asignacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AsignacionApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Asignacion::with(['usuario', 'materialRecibido'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'numeroTurno' => 'required|integer|min:0',
            'fechaInicio' => 'required|date',
            'fechaFinalizacion' => 'required|date|after_or_equal:fechaInicio',
            'prioridad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'observacion' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
            'material_recibido_id' => 'required|exists:material_recibidos,id',
        ]);

        $asignacion = Asignacion::create($datos);
        return response()->json($asignacion->load(['usuario', 'materialRecibido']), 201);
    }

    public function show(Asignacion $asignacion): JsonResponse
    {
        return response()->json($asignacion->load(['usuario', 'materialRecibido']));
    }

    public function update(Request $request, Asignacion $asignacion): JsonResponse
    {
        $datos = $request->validate([
            'numeroTurno' => 'sometimes|integer|min:0',
            'fechaInicio' => 'sometimes|date',
            'fechaFinalizacion' => 'sometimes|date|after_or_equal:fechaInicio',
            'prioridad' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:255',
            'observacion' => 'sometimes|string|max:255',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'material_recibido_id' => 'sometimes|exists:material_recibidos,id',
        ]);

        $asignacion->update($datos);
        return response()->json($asignacion->load(['usuario', 'materialRecibido']));
    }

    public function destroy(Asignacion $asignacion): JsonResponse
    {
        $asignacion->delete();
        return response()->json(null, 204);
    }
}