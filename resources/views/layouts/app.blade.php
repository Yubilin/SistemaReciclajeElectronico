<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Usuarios')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #222; }
        nav { background: #f3f4f6; padding: 1rem 2rem; }
        main { max-width: 960px; margin: 2rem auto; padding: 0 1rem; }
        a { color: #166534; margin-right: .75rem; }
        table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
        th, td { border: 1px solid #ddd; padding: .65rem; text-align: left; }
        label { display: block; margin-top: 1rem; }
        input { box-sizing: border-box; display: block; margin-top: .35rem; padding: .5rem; width: 100%; }
        button { cursor: pointer; margin-top: 1rem; padding: .5rem .8rem; }
        .success { background: #dcfce7; padding: .75rem; }
        .error { color: #b91c1c; }
        form.inline { display: inline; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('usuarios.index') }}">Usuarios</a>
        <a href="{{ route('componentes.index') }}">Componentes</a>
        <a href="{{ route('categorias.index') }}">Categorías</a>
        <a href="{{ route('entregantes.index') }}">Entregantes</a>
        <a href="{{ route('recepciones.index') }}">Recepciones</a>
        <a href="{{ route('materiales-recibidos.index') }}">Materiales recibidos</a>
        <a href="{{ route('recuperaciones.index') }}">Recuperaciones</a>
        <a href="{{ route('inventarios.index') }}">Inventarios</a>
        <a href="{{ route('asignaciones.index') }}">Asignaciones</a>
    </nav>
    <main>
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
        @yield('content')
    </main>
</body>
</html>
