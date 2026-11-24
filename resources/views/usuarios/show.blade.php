@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
    <x-page-header title="Detalle de usuario" :subtitle="'Usuario #' . $usuario->id">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a usuarios
        </a>
        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1" aria-hidden="true"></i>Editar
        </a>
        <button type="button" class="btn btn-outline-danger"
                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                data-delete-url="{{ route('usuarios.destroy', $usuario) }}"
                data-delete-label="el usuario {{ $usuario->nombre }} {{ $usuario->apellido }}">
            <i class="bi bi-trash me-1" aria-hidden="true"></i>Eliminar
        </button>
    </x-page-header>

    <div class="card">
        <div class="card-body px-4 py-3">
            <div class="d-flex align-items-center gap-3 pb-3 border-bottom">
                <span class="raee-avatar raee-avatar--lg" aria-hidden="true">{{ mb_substr($usuario->nombre, 0, 1) }}{{ mb_substr($usuario->apellido, 0, 1) }}</span>
                <div>
                    <div class="h5 mb-0">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                    <div class="text-body-secondary">{{ $usuario->correo }}</div>
                </div>
            </div>

            <dl class="mb-0">
                <div class="row raee-dl-row">
                    <dt class="col-sm-4">Nombre</dt>
                    <dd class="col-sm-8">{{ $usuario->nombre }}</dd>
                </div>
                <div class="row raee-dl-row">
                    <dt class="col-sm-4">Apellido</dt>
                    <dd class="col-sm-8">{{ $usuario->apellido }}</dd>
                </div>
                <div class="row raee-dl-row">
                    <dt class="col-sm-4">Correo</dt>
                    <dd class="col-sm-8">{{ $usuario->correo }}</dd>
                </div>
                <div class="row raee-dl-row">
                    <dt class="col-sm-4">Rol</dt>
                    <dd class="col-sm-8"><span class="raee-badge raee-badge--info">{{ $usuario->rol }}</span></dd>
                </div>
                <div class="row raee-dl-row">
                    <dt class="col-sm-4">Estado</dt>
                    <dd class="col-sm-8"><x-estado-badge :valor="$usuario->estado" /></dd>
                </div>
            </dl>
        </div>

        <div class="card-footer small text-body-secondary d-flex flex-wrap gap-3 py-3">
            <span><i class="bi bi-calendar-plus me-1" aria-hidden="true"></i>Creado: {{ $usuario->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
            <span><i class="bi bi-clock-history me-1" aria-hidden="true"></i>Actualizado: {{ $usuario->updated_at?->format('d/m/Y H:i') ?? '—' }}</span>
        </div>
    </div>

    @include('partials.delete-modal')
@endsection
