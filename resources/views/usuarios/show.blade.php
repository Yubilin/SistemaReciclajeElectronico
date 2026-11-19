@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
    <h1>Detalle de usuario</h1>
    <dl>
        <dt>Nombre</dt>
        <dd>{{ $usuario->nombre }}</dd>
        <dt>Apellido</dt>
        <dd>{{ $usuario->apellido }}</dd>
        <dt>Correo</dt>
        <dd>{{ $usuario->correo }}</dd>
        <dt>Rol</dt>
        <dd>{{ $usuario->rol }}</dd>
        <dt>Estado</dt>
        <dd>{{ $usuario->estado }}</dd>
    </dl>
    <a href="{{ route('usuarios.edit', $usuario) }}">Editar</a>
    <a href="{{ route('usuarios.index') }}">Volver a usuarios</a>
@endsection
