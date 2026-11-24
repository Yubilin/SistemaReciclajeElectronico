@extends('layouts.app')

@section('title', $titulo)

@php
    // Campos que ocupan todo el ancho.
    $anchoCompleto = ['descripcion', 'observaciones', 'observacion', 'direccion'];
@endphp

@section('content')
    <x-page-header :title="$titulo">
        <a href="{{ route($ruta . '.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver al listado
        </a>
    </x-page-header>

    <div class="card">
        <form action="{{ $registro ? route($ruta . '.update', $registro) : route($ruta . '.store') }}"
              method="POST" class="card-body p-4">
            @csrf
            @if ($registro)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2" aria-hidden="true"></i>
                    <div>Revisa los campos marcados en rojo antes de continuar.</div>
                </div>
            @endif

            <div class="row g-3">
                @foreach ($campos as $nombre => $campo)
                    @php($actual = old($nombre, $registro ? $registro->{$nombre} : ''))

                    <div class="{{ in_array($nombre, $anchoCompleto, true) ? 'col-12' : 'col-md-6' }}">
                        <label for="{{ $nombre }}" class="form-label">{{ $campo['label'] }}</label>

                        @if ($campo['type'] === 'select')
                            <select id="{{ $nombre }}" name="{{ $nombre }}"
                                    class="form-select @error($nombre) is-invalid @enderror" required>
                                <option value="">Selecciona una opción</option>
                                @foreach ($campo['options'] as $opcionValor => $opcionEtiqueta)
                                    <option value="{{ $opcionValor }}" @selected((string) $actual === (string) $opcionValor)>
                                        {{ $opcionEtiqueta }}
                                    </option>
                                @endforeach
                                {{-- Valor antiguo que ya no está en el catálogo: se conserva visible. --}}
                                @if ($actual !== '' && $actual !== null && ! array_key_exists((string) $actual, $campo['options'] instanceof \Illuminate\Support\Collection ? $campo['options']->all() : $campo['options']))
                                    <option value="{{ $actual }}" selected>{{ $actual }} (valor actual)</option>
                                @endif
                            </select>
                            @if (count($campo['options']) === 0)
                                <div class="form-text text-warning-emphasis">
                                    <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                                    No hay opciones disponibles. Crea primero el registro relacionado.
                                </div>
                            @endif
                        @else
                            <input id="{{ $nombre }}" name="{{ $nombre }}" type="{{ $campo['type'] }}"
                                   value="{{ $actual }}"
                                   class="form-control @error($nombre) is-invalid @enderror"
                                   @if ($campo['type'] === 'number') min="0" step="1" @endif
                                   required>
                        @endif

                        @error($nombre)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route($ruta . '.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i>{{ $registro ? 'Guardar cambios' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
@endsection
