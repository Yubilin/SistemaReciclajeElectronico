@extends('layouts.app')

@section('title', 'Crear usuario')

@section('content')
    <x-page-header title="Crear usuario">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a usuarios
        </a>
    </x-page-header>

    <div class="card">
        @include('usuarios._form', ['usuario' => null, 'roles' => $roles, 'estados' => $estados])
    </div>
@endsection
