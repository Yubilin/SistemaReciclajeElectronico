<?php

namespace App\Filament\Widgets;

use App\Models\MaterialRecibido;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MaterialesPorCategoriaChart extends ChartWidget
{
    protected static ?string $heading = 'Materiales por Categoría';
    protected static ?string $description = 'Cantidad de registros recibidos en cada categoría.';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $datos = MaterialRecibido::join('categorias', 'material_recibidos.categoria_id', '=', 'categorias.id')
            ->select('categorias.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('categorias.nombre')
            ->get();

        $colores = ['#056C8E', '#659F17', '#116D64', '#f59e0b', '#04556f', '#4f7d12'];

        return [
            'datasets' => [
                [
                    'label' => 'Materiales',
                    'data' => $datos->pluck('total')->toArray(),
                    'backgroundColor' => $colores,
                    'borderColor' => '#056C8E',
                    'borderWidth' => 2,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $datos->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}   