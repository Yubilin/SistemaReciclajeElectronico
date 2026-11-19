@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <h1>Editar usuario</h1>
    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
        @error('nombre') <p class="error">{{ $message }}</p> @enderror

        <label for="apellido">Apellido</label>
        <input id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" required>
        @error('apellido') <p class="error">{{ $message }}</p> @enderror

        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" value="{{ old('correo', $usuario->correo) }}" required>
        @error('correo') <p class="error">{{ $message }}</p> @enderror

        <label for="contraseña">Nueva contraseña (opcional)</label>
        <input id="contraseña" name="contraseña" type="password">
        @error('contraseña') <p class="error">{{ $message }}</p> @enderror

        <label for="rol">Rol</label>
        <input id="rol" name="rol" value="{{ old('rol', $usuario->rol) }}" required>
        @error('rol') <p class="error">{{ $message }}</p> @enderror

        <label for="estado">Estado</label>
        <input id="estado" name="estado" value="{{ old('estado', $usuario->estado) }}" required>
        @error('estado') <p class="error">{{ $message }}</p> @enderror

        <button type="submit">Actualizar</button>
    </form>
    <a href="{{ route('usuarios.index') }}">Volver a usuarios</a>
@endsection
