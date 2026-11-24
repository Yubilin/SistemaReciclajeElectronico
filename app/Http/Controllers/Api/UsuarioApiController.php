<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Support\Catalogo;

class UsuarioApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Usuario::paginate(10));
    }

    public function store(Request $request): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:8',
            'rol' => ['required', Catalogo::regla('roles')],
            'estado' => ['required', Catalogo::regla('estados.usuarios')],
        ]);

        $datos['contraseña'] = Hash::make($datos['contraseña']);
        $usuario = Usuario::create($datos);

        return response()->json($usuario, 201);
    }

    public function show(Usuario $usuario): JsonResponse
    {
        return response()->json($usuario->load(['recepciones', 'asignaciones']));
    }

    public function update(Request $request, Usuario $usuario): JsonResponse
    {
        $datos = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . $usuario->id,
            'contraseña' => 'sometimes|string|min:8',
            'rol' => ['sometimes', Catalogo::regla('roles')],
            'estado' => ['sometimes', Catalogo::regla('estados.usuarios')],
        ]);

        if (isset($datos['contraseña'])) {
            $datos['contraseña'] = Hash::make($datos['contraseña']);
        }

        $usuario->update($datos);
        return response()->json($usuario);
    }

    public function destroy(Usuario $usuario): JsonResponse
    {
        $usuario->delete();
        return response()->json(null, 204);
    }
}