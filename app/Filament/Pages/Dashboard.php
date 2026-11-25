<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\MaterialesPorCategoriaChart;
use App\Filament\Widgets\RecepcionesRecientesChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MaterialesPorCategoriaChart::class,
            RecepcionesRecientesChart::class,
        ];
    }
}