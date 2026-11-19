@extends('layouts.app')

@section('title', 'Crear usuario')

@section('content')
    <h1>Crear usuario</h1>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        @error('nombre') <p class="error">{{ $message }}</p> @enderror

        <label for="apellido">Apellido</label>
        <input id="apellido" name="apellido" value="{{ old('apellido') }}" required>
        @error('apellido') <p class="error">{{ $message }}</p> @enderror

        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" value="{{ old('correo') }}" required>
        @error('correo') <p class="error">{{ $message }}</p> @enderror

        <label for="contraseña">Contraseña</label>
        <input id="contraseña" name="contraseña" type="password" required>
        @error('contraseña') <p class="error">{{ $message }}</p> @enderror

        <label for="rol">Rol</label>
        <input id="rol" name="rol" value="{{ old('rol') }}" required>
        @error('rol') <p class="error">{{ $message }}</p> @enderror

        <label for="estado">Estado</label>
        <input id="estado" name="estado" value="{{ old('estado') }}" required>
        @error('estado') <p class="error">{{ $message }}</p> @enderror

        <button type="submit">Guardar</button>
    </form>
    <a href="{{ route('usuarios.index') }}">Volver a usuarios</a>
@endsection
