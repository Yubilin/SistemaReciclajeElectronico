@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header title="Dashboard" subtitle="Resumen de la trazabilidad de residuos de aparatos eléctricos y electrónicos.">
        <a href="{{ route('materiales-recibidos.create') }}" class="btn btn-outline-secondary">
            <i class="bi bi-pc-display-horizontal me-1" aria-hidden="true"></i>Registrar material
        </a>
        <a href="{{ route('recepciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Nueva recepción
        </a>
    </x-page-header>

    {{-- KPIs --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3 mb-4">
        <div class="col">
            <x-kpi-card label="Recepciones" :value="$kpis['recepciones']" icon="box-arrow-in-down"
                        tone="primary" :href="route('recepciones.index')" />
        </div>
        <div class="col">
            <x-kpi-card label="Materiales recibidos" hint="unidades" :value="$kpis['materiales']" icon="pc-display-horizontal"
                        tone="cyan" :href="route('materiales-recibidos.index')" />
        </div>
        <div class="col">
            <x-kpi-card label="Recuperaciones" :value="$kpis['recuperaciones']" icon="recycle"
                        tone="lime" :href="route('recuperaciones.index')" />
        </div>
        <div class="col">
            <x-kpi-card label="Componentes recuperados" hint="unidades" :value="$kpis['componentes']" icon="cpu"
                        tone="primary" :href="route('componentes.index')" />
        </div>
        <div class="col">
            <x-kpi-card label="Asignaciones" :value="$kpis['asignaciones']" icon="clipboard-check"
                        tone="cyan" :href="route('asignaciones.index')" />
        </div>
        <div class="col">
            <x-kpi-card label="Alertas de stock bajo" hint="en o bajo el mínimo" :value="$kpis['stockBajo']" icon="exclamation-triangle"
                        tone="amber" :href="route('inventarios.index')" />
        </div>
    </div>

    <div class="row g-3">
        {{-- Movimientos recientes --}}
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h2 class="h6 mb-0">Últimas recepciones</h2>
                    <a href="{{ route('recepciones.index') }}" class="small text-decoration-none">Ver todas</a>
                </div>

                @if ($recepcionesRecientes->isEmpty())
                    <div class="raee-empty">
                        <i class="bi bi-inbox" aria-hidden="true"></i>
                        <p class="mb-3">Aún no hay recepciones registradas.</p>
                        <a href="{{ route('recepciones.create') }}" class="btn btn-primary btn-sm">Registrar la primera</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-raee table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Entregante</th>
                                    <th scope="col">Recibido por</th>
                                    <th scope="col" class="text-end">Materiales</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col"><span class="visually-hidden">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recepcionesRecientes as $recepcion)
                                    <tr>
                                        <td class="text-nowrap">{{ $recepcion->fecha }}</td>
                                        <td>{{ $recepcion->entregante?->nombre }} {{ $recepcion->entregante?->apellido }}</td>
                                        <td>{{ $recepcion->usuario?->nombre }} {{ $recepcion->usuario?->apellido }}</td>
                                        <td class="text-end">{{ $recepcion->materiales_recibidos_count }}</td>
                                        <td><x-estado-badge :valor="$recepcion->estado" /></td>
                                        <td class="text-end">
                                            <a href="{{ route('recepciones.show', $recepcion) }}"
                                               class="btn btn-sm btn-outline-secondary" title="Ver detalle" aria-label="Ver detalle">
                                                <i class="bi bi-eye" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Alertas de stock --}}
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h2 class="h6 mb-0">Stock bajo</h2>
                    <a href="{{ route('inventarios.index') }}" class="small text-decoration-none">Inventario</a>
                </div>

                @if ($alertasStock->isEmpty())
                    <div class="raee-empty">
                        <i class="bi bi-check-circle" aria-hidden="true"></i>
                        <p class="mb-0">Sin alertas: todos los componentes están sobre su mínimo.</p>
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($alertasStock as $item)
                            <li class="list-group-item d-flex align-items-center justify-content-between gap-3 py-3">
                                <div class="min-w-0">
                                    <div class="fw-medium text-truncate">{{ $item->componente?->nombre ?? 'Componente' }}</div>
                                    <div class="small text-body-secondary">Mínimo: {{ $item->cantidadMinima }}</div>
                                </div>
                                <span class="raee-badge raee-badge--warn">{{ $item->cantidadDisponible }} disp.</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
