@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <x-page-header title="Usuarios" :subtitle="$usuarios->total() . ' ' . ($usuarios->total() === 1 ? 'usuario registrado' : 'usuarios registrados')">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1" aria-hidden="true"></i>Nuevo usuario
        </a>
    </x-page-header>

    <div class="card">
        @if ($usuarios->isEmpty())
            <div class="raee-empty">
                <i class="bi bi-people" aria-hidden="true"></i>
                <p class="mb-3">No hay usuarios registrados.</p>
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1" aria-hidden="true"></i>Crear el primero
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-raee table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="raee-id">{{ $usuario->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="raee-avatar" aria-hidden="true">{{ mb_substr($usuario->nombre, 0, 1) }}{{ mb_substr($usuario->apellido, 0, 1) }}</span>
                                        <div>
                                            <div class="fw-medium">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                                            <div class="small text-body-secondary">{{ $usuario->correo }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="raee-badge raee-badge--info">{{ $usuario->rol }}</span></td>
                                <td><x-estado-badge :valor="$usuario->estado" /></td>
                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Acciones del usuario {{ $usuario->id }}">
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-outline-secondary"
                                           title="Ver" aria-label="Ver">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-outline-primary"
                                           title="Editar" aria-label="Editar">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                data-delete-url="{{ route('usuarios.destroy', $usuario) }}"
                                                data-delete-label="el usuario {{ $usuario->nombre }} {{ $usuario->apellido }}"
                                                title="Eliminar" aria-label="Eliminar">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($usuarios->hasPages())
                <div class="card-footer py-3">
                    {{ $usuarios->links() }}
                </div>
            @endif
        @endif
    </div>

    @include('partials.delete-modal')
@endsection
