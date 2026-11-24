@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <x-page-header title="Editar usuario" :subtitle="$usuario->nombre . ' ' . $usuario->apellido">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a usuarios
        </a>
    </x-page-header>

    <div class="card">
        @include('usuarios._form', ['usuario' => $usuario, 'roles' => $roles, 'estados' => $estados])
    </div>
@endsection
