@extends('layouts.app')

@section('title', $titulo)

@php
    // Campos que se muestran como badge de estado (solo presentación).
    $camposBadge = ['estado', 'prioridad', 'resultado'];
@endphp

@section('content')
    <x-page-header :title="$titulo" :subtitle="$registros->total() . ' ' . ($registros->total() === 1 ? 'registro' : 'registros')">
        <a href="{{ route($ruta . '.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Nuevo registro
        </a>
    </x-page-header>

    <div class="card">
        @if ($registros->isEmpty())
            <div class="raee-empty">
                <i class="bi bi-inbox" aria-hidden="true"></i>
                <p class="mb-3">No hay registros todavía.</p>
                <a href="{{ route($ruta . '.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Crear el primero
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-raee table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            @foreach ($campos as $campo)
                                <th scope="col">{{ $campo['label'] }}</th>
                            @endforeach
                            <th scope="col" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                            <tr>
                                <td class="raee-id">{{ $registro->id }}</td>

                                @foreach ($campos as $nombre => $campo)
                                    @php($valor = data_get($registro, $campo['relation'] ?? $nombre))
                                    <td>
                                        @if (in_array($nombre, $camposBadge, true))
                                            <x-estado-badge :valor="$valor" />
                                        @elseif ($campo['type'] === 'number')
                                            <span class="text-nowrap">{{ $valor }}</span>
                                        @else
                                            <span class="raee-truncate" title="{{ $valor }}">{{ $valor }}</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="text-end text-nowrap">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Acciones del registro {{ $registro->id }}">
                                        <a href="{{ route($ruta . '.show', $registro) }}" class="btn btn-outline-secondary"
                                           title="Ver" aria-label="Ver">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route($ruta . '.edit', $registro) }}" class="btn btn-outline-primary"
                                           title="Editar" aria-label="Editar">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                data-delete-url="{{ route($ruta . '.destroy', $registro) }}"
                                                data-delete-label="{{ $titulo }} #{{ $registro->id }}"
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

            @if ($registros->hasPages())
                <div class="card-footer py-3">
                    {{ $registros->links() }}
                </div>
            @endif
        @endif
    </div>

    @include('partials.delete-modal')
@endsection
