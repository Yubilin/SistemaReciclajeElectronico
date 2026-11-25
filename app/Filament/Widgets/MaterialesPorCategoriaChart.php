<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use Filament\Widgets\ChartWidget;

class MaterialesPorCategoriaChart extends ChartWidget
{
    protected static ?string $heading = 'Materiales por Categoría';

    protected function getData(): array
    {
        $categorias = Categoria::withCount('materialesRecibidos')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de materiales',
                    'data' => $categorias->pluck('materiales_recibidos_count')->toArray(),
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
                    ],
                ],
            ],
            'labels' => $categorias->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}