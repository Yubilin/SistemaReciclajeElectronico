@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <h1>Usuarios</h1>
    <a href="{{ route('usuarios.create') }}">Crear usuario</a>

    @if ($usuarios->isEmpty())
        <p>No hay usuarios registrados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellido }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->rol }}</td>
                        <td>{{ $usuario->estado }}</td>
                        <td>
                            <a href="{{ route('usuarios.show', $usuario) }}">Ver</a>
                            <a href="{{ route('usuarios.edit', $usuario) }}">Editar</a>
                            <form class="inline" action="{{ route('usuarios.destroy', $usuario) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $usuarios->links() }}
    @endif
@endsection
