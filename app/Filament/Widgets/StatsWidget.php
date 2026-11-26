<?php

namespace App\Filament\Widgets;

use App\Models\MaterialRecibido;
use App\Models\Recepcion;
use App\Models\Recuperacion;
use App\Models\Inventario;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    protected static ?int $sort = -1;

    protected function getStats(): array
    {
        // Contar unidades recibidas sumando la columna cantidad
        $unidadesRecibidas = MaterialRecibido::sum('cantidad');

        // Componentes con stock por debajo del mínimo
        $stockPorReponer = Inventario::whereColumn('cantidadDisponible', '<=', 'cantidadMinima')->count();

        return [
            Stat::make('Recepciones', Recepcion::count())
                ->description('Ingresos registrados')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('primary'),

            Stat::make('Unidades recibidas', $unidadesRecibidas)
                ->description('Unidades declaradas en las recepciones')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('Recuperaciones', Recuperacion::count())
                ->description('Procesos de recuperación registrados')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('success'),

            Stat::make('Stock por reponer', $stockPorReponer)
                ->description('Componentes en nivel mínimo o inferior')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}