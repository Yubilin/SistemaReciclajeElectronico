<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\asignacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Support\Catalogo;

class AsignacionApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            asignacion::with(['usuario', 'materialRecibido'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'numeroTurno' => 'required|integer|min:0',
            'fechaInicio' => 'required|date',
            'fechaFinalizacion' => 'required|date|after_or_equal:fechaInicio',
            'prioridad' => ['required', Catalogo::regla('prioridades')],
            'estado' => ['required', Catalogo::regla('estados.asignaciones')],
            'observacion' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
            'material_recibido_id' => 'required|exists:material_recibidos,id',
        ]);

        $asignacion = asignacion::create($datos);
        return response()->json($asignacion->load(['usuario', 'materialRecibido']), 201);
    }

    public function show(asignacion $asignacion): JsonResponse
    {
        return response()->json($asignacion->load(['usuario', 'materialRecibido']));
    }

    public function update(Request $request, asignacion $asignacion): JsonResponse
    {
        $datos = $request->validate([
            'numeroTurno' => 'sometimes|integer|min:0',
            'fechaInicio' => 'sometimes|date',
            'fechaFinalizacion' => 'sometimes|date|after_or_equal:fechaInicio',
            'prioridad' => ['sometimes', Catalogo::regla('prioridades')],
            'estado' => ['sometimes', Catalogo::regla('estados.asignaciones')],
            'observacion' => 'sometimes|string|max:255',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'material_recibido_id' => 'sometimes|exists:material_recibidos,id',
        ]);

        $asignacion->update($datos);
        return response()->json($asignacion->load(['usuario', 'materialRecibido']));
    }

    public function destroy(asignacion $asignacion): JsonResponse
    {
        $asignacion->delete();
        return response()->json(null, 204);
    }
}