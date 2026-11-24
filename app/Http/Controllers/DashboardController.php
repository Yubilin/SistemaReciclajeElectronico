<?php

namespace App\Http\Controllers;

use App\Models\asignacion;
use App\Models\Componentes;
use App\Models\Inventario;
use App\Models\materialRecibido;
use App\Models\Recepcion;
use App\Models\recuperacion;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stockBajo = Inventario::query()
            ->whereColumn('cantidadDisponible', '<=', 'cantidadMinima');

        $kpis = [
            'recepciones' => Recepcion::count(),
            'materiales' => (int) materialRecibido::sum('cantidad'),
            'recuperaciones' => recuperacion::count(),
            'componentes' => (int) Componentes::sum('cantidad'),
            'asignaciones' => asignacion::count(),
            'stockBajo' => (clone $stockBajo)->count(),
        ];

        $recepcionesRecientes = Recepcion::query()
            ->with(['usuario', 'entregante'])
            ->withCount('materialesRecibidos')
            ->latest('fecha')
            ->latest('id')
            ->limit(8)
            ->get();

        $alertasStock = (clone $stockBajo)
            ->with('componente')
            ->orderBy('cantidadDisponible')
            ->limit(5)
            ->get();

        return view('dashboard', compact('kpis', 'recepcionesRecientes', 'alertasStock'));
    }
}
