<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') · RAEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/raee-theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="raee-shell">
        @include('partials.sidebar')

        <div class="raee-main">
            <header class="raee-topbar">
                <div class="raee-topbar-inner">
                    <button class="btn btn-link text-white d-lg-none p-0 fs-3 lh-1" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#raeeSidebar"
                            aria-controls="raeeSidebar" aria-label="Abrir menú">
                        <i class="bi bi-list" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="raee-topbar-brand d-lg-none">RAEE</a>
                    <span class="raee-topbar-tagline d-none d-lg-inline">Gestión y trazabilidad de residuos electrónicos</span>

                    <a href="{{ route('recepciones.create') }}" class="btn btn-sm btn-primary ms-auto">
                        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Nueva recepción
                    </a>
                </div>
            </header>

            <main class="raee-content">
                @include('partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
