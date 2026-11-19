@extends('layouts.app')

@section('title', $titulo)

@section('content')
    <h1>{{ $titulo }}</h1>
    <form action="{{ $registro ? route($ruta . '.update', $registro) : route($ruta . '.store') }}" method="POST">
        @csrf
        @if ($registro)
            @method('PUT')
        @endif

        @foreach ($campos as $nombre => $campo)
            <label for="{{ $nombre }}">{{ $campo['label'] }}</label>
            @if ($campo['type'] === 'select')
                <select id="{{ $nombre }}" name="{{ $nombre }}" required>
                    <option value="">Selecciona una opción</option>
                    @foreach ($campo['options'] as $valor => $etiqueta)
                        <option value="{{ $valor }}" @selected((string) old($nombre, $registro ? $registro->{$nombre} : '') === (string) $valor)>
                            {{ $etiqueta }}
                        </option>
                    @endforeach
                </select>
            @else
                <input
                    id="{{ $nombre }}"
                    name="{{ $nombre }}"
                    type="{{ $campo['type'] }}"
                    value="{{ old($nombre, $registro ? $registro->{$nombre} : '') }}"
                    @if ($campo['type'] === 'number') min="0" step="1" @endif
                    required
                >
            @endif
            @error($nombre) <p class="error">{{ $message }}</p> @enderror
        @endforeach

        <button type="submit">{{ $registro ? 'Actualizar' : 'Guardar' }}</button>
    </form>
    <a href="{{ route($ruta . '.index') }}">Volver al listado</a>
@endsection
