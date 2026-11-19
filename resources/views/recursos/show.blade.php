@extends('layouts.app')

@section('title', $titulo)

@section('content')
    <h1>{{ $titulo }}</h1>
    <dl>
        @foreach ($campos as $nombre => $campo)
            <dt>{{ $campo['label'] }}</dt>
            <dd>{{ data_get($registro, $campo['relation'] ?? $nombre) }}</dd>
        @endforeach
    </dl>
    <a href="{{ route($ruta . '.edit', $registro) }}">Editar</a>
    <a href="{{ route($ruta . '.index') }}">Volver al listado</a>
@endsection
