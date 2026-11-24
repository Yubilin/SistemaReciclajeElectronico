@extends('layouts.app')

@section('title', $titulo)

@php
    $camposBadge = ['estado', 'prioridad', 'resultado'];
@endphp

@section('content')
    <x-page-header :title="$titulo" :subtitle="'Registro #' . $registro->id">
        <a href="{{ route($ruta . '.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver al listado
        </a>
        <a href="{{ route($ruta . '.edit', $registro) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1" aria-hidden="true"></i>Editar
        </a>
        <button type="button" class="btn btn-outline-danger"
                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                data-delete-url="{{ route($ruta . '.destroy', $registro) }}"
                data-delete-label="este registro (#{{ $registro->id }})">
            <i class="bi bi-trash me-1" aria-hidden="true"></i>Eliminar
        </button>
    </x-page-header>

    <div class="card">
        <div class="card-body px-4 py-2">
            <dl class="mb-0">
                @foreach ($campos as $nombre => $campo)
                    @php($valor = data_get($registro, $campo['relation'] ?? $nombre))
                    <div class="row raee-dl-row">
                        <dt class="col-sm-4">{{ $campo['label'] }}</dt>
                        <dd class="col-sm-8">
                            @if (in_array($nombre, $camposBadge, true))
                                <x-estado-badge :valor="$valor" />
                            @else
                                {{ $valor !== null && $valor !== '' ? $valor : '—' }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="card-footer small text-body-secondary d-flex flex-wrap gap-3 py-3">
            <span><i class="bi bi-calendar-plus me-1" aria-hidden="true"></i>Creado: {{ $registro->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
            <span><i class="bi bi-clock-history me-1" aria-hidden="true"></i>Actualizado: {{ $registro->updated_at?->format('d/m/Y H:i') ?? '—' }}</span>
        </div>
    </div>

    @include('partials.delete-modal')
@endsection
