<?php

namespace App\Filament\Widgets;

use App\Models\Usuario;
use App\Models\Entregante;
use App\Models\Recepcion;
use App\Models\MaterialRecibido;
use App\Models\Componentes;
use App\Models\Inventario;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios', Usuario::count())
                ->description('Total de usuarios registrados')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Entregantes', Entregante::count())
                ->description('Total de entregantes')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),

            Stat::make('Recepciones', Recepcion::count())
                ->description('Total de recepciones')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('warning'),

            Stat::make('Materiales Recibidos', MaterialRecibido::count())
                ->description('Total de materiales')
                ->descriptionIcon('heroicon-m-cube')
                ->color('danger'),

            Stat::make('Componentes', Componentes::count())
                ->description('Total de componentes')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),

            Stat::make('Inventarios', Inventario::count())
                ->description('Items en inventario')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('gray'),
        ];
    }
}