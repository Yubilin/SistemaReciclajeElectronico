@php
    // Configuración de presentación del menú (sin lógica de negocio).
    $menu = [
        'Principal' => [
            ['route' => 'dashboard', 'match' => 'dashboard', 'icon' => 'speedometer2', 'label' => 'Dashboard'],
        ],
        'Recepción' => [
            ['route' => 'entregantes.index', 'match' => 'entregantes.*', 'icon' => 'person-vcard', 'label' => 'Entregantes'],
            ['route' => 'recepciones.index', 'match' => 'recepciones.*', 'icon' => 'box-arrow-in-down', 'label' => 'Recepciones'],
            ['route' => 'materiales-recibidos.index', 'match' => 'materiales-recibidos.*', 'icon' => 'pc-display-horizontal', 'label' => 'Materiales recibidos'],
        ],
        'Recuperación' => [
            ['route' => 'recuperaciones.index', 'match' => 'recuperaciones.*', 'icon' => 'recycle', 'label' => 'Recuperaciones'],
            ['route' => 'componentes.index', 'match' => 'componentes.*', 'icon' => 'cpu', 'label' => 'Componentes'],
            ['route' => 'inventarios.index', 'match' => 'inventarios.*', 'icon' => 'boxes', 'label' => 'Inventarios'],
            ['route' => 'asignaciones.index', 'match' => 'asignaciones.*', 'icon' => 'clipboard-check', 'label' => 'Asignaciones'],
        ],
        'Catálogos y accesos' => [
            ['route' => 'categorias.index', 'match' => 'categorias.*', 'icon' => 'tags', 'label' => 'Categorías'],
            ['route' => 'usuarios.index', 'match' => 'usuarios.*', 'icon' => 'people', 'label' => 'Usuarios'],
        ],
    ];
@endphp

<div class="raee-sidebar-wrap">
    <aside class="offcanvas-lg offcanvas-start raee-sidebar" tabindex="-1" id="raeeSidebar" aria-label="Menú principal">
        <div class="offcanvas-body">
            <div class="raee-sidebar-inner">
                <div class="d-flex align-items-start justify-content-between">
                    <a href="{{ route('dashboard') }}" class="raee-brand">
                        <span class="raee-brand__logo"><i class="bi bi-recycle" aria-hidden="true"></i></span>
                        <span>
                            <span class="raee-brand__name">RAEE</span>
                            <span class="raee-brand__tag">Trazabilidad de reciclaje</span>
                        </span>
                    </a>
                    <button type="button" class="btn-close btn-close-white d-lg-none mt-2"
                            data-bs-dismiss="offcanvas" data-bs-target="#raeeSidebar" aria-label="Cerrar menú"></button>
                </div>

                <nav aria-label="Navegación principal">
                    @foreach ($menu as $grupo => $items)
                        <p class="raee-nav-label">{{ $grupo }}</p>
                        <ul class="nav flex-column mb-3">
                            @foreach ($items as $item)
                                @php($activo = request()->routeIs($item['match']))
                                <li class="nav-item">
                                    <a href="{{ route($item['route']) }}"
                                       class="raee-nav-link @if ($activo) active @endif"
                                       @if ($activo) aria-current="page" @endif>
                                        <i class="bi bi-{{ $item['icon'] }}" aria-hidden="true"></i>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </nav>
            </div>
        </div>
    </aside>
</div>
