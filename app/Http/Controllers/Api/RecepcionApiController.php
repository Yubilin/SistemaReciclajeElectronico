<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recepcion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Support\Catalogo;

class RecepcionApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Recepcion::with(['usuario', 'entregante', 'materialesRecibidos'])->paginate(10)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'fecha' => 'required|date',
            'observaciones' => 'required|string|max:255',
            'estado' => ['required', Catalogo::regla('estados.recepciones')],
            'usuario_id' => 'required|exists:usuarios,id',
            'entregante_id' => 'required|exists:entregantes,id',
        ]);

        $recepcion = Recepcion::create($datos);
        return response()->json($recepcion->load(['usuario', 'entregante']), 201);
    }

    public function show(Recepcion $recepcion): JsonResponse
    {
        return response()->json($recepcion->load(['usuario', 'entregante', 'materialesRecibidos']));
    }

    public function update(Request $request, Recepcion $recepcion): JsonResponse
    {
        $datos = $request->validate([
            'fecha' => 'sometimes|date',
            'observaciones' => 'sometimes|string|max:255',
            'estado' => ['sometimes', Catalogo::regla('estados.recepciones')],
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'entregante_id' => 'sometimes|exists:entregantes,id',
        ]);

        $recepcion->update($datos);
        return response()->json($recepcion->load(['usuario', 'entregante']));
    }

    public function destroy(Recepcion $recepcion): JsonResponse
    {
        $recepcion->delete();
        return response()->json(null, 204);
    }
}