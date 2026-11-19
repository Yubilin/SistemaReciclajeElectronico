<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $usuarios = Usuario::query()->orderBy('id')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
            'contraseña' => ['required', 'string', 'min:8', 'max:255'],
            'rol' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
        ]);
        $datos['contraseña'] = Hash::make($datos['contraseña']);

        Usuario::create($datos);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('usuarios', 'correo')->ignore($usuario->id),
            ],
            'contraseña' => ['nullable', 'string', 'min:8', 'max:255'],
            'rol' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'max:255'],
        ]);

        if (blank($datos['contraseña'] ?? null)) {
            unset($datos['contraseña']);
        } else {
            $datos['contraseña'] = Hash::make($datos['contraseña']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario): RedirectResponse
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
