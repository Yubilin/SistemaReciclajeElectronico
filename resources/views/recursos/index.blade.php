@extends('layouts.app')

@section('title', $titulo)

@section('content')
    <h1>{{ $titulo }}</h1>
    <a href="{{ route($ruta . '.create') }}">Crear registro</a>

    @if ($registros->isEmpty())
        <p>No hay registros.</p>
    @else
        <table>
            <thead>
                <tr>
                    @foreach ($campos as $campo)
                        <th>{{ $campo['label'] }}</th>
                    @endforeach
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $registro)
                    <tr>
                        @foreach ($campos as $nombre => $campo)
                            <td>{{ data_get($registro, $campo['relation'] ?? $nombre) }}</td>
                        @endforeach
                        <td>
                            <a href="{{ route($ruta . '.show', $registro) }}">Ver</a>
                            <a href="{{ route($ruta . '.edit', $registro) }}">Editar</a>
                            <form class="inline" action="{{ route($ruta . '.destroy', $registro) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $registros->links() }}
    @endif
@endsection
