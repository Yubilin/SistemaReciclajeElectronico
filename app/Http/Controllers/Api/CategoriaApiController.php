<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(categoria::paginate(10));
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        $categoria = categoria::create($datos);
        return response()->json($categoria, 201);
    }

    public function show(categoria $categoria): JsonResponse
    {
        return response()->json($categoria->load('materialesRecibidos'));
    }

    public function update(Request $request, categoria $categoria): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:255',
        ]);

        $categoria->update($datos);
        return response()->json($categoria);
    }

    public function destroy(categoria $categoria): JsonResponse
    {
        $categoria->delete();
        return response()->json(null, 204);
    }
}