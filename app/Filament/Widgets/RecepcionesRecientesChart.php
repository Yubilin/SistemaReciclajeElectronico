<?php

namespace App\Filament\Widgets;

use App\Models\Recepcion;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RecepcionesRecientesChart extends ChartWidget
{
    protected static ?string $heading = 'Recepciones por Mes';
    protected static ?string $description = 'Evolución mensual de los ingresos de materiales.';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $recepciones = Recepcion::select(
            DB::raw("TO_CHAR(fecha, 'YYYY-MM') as mes"),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(DB::raw("TO_CHAR(fecha, 'YYYY-MM')"))
        ->orderBy('mes')
        ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Recepciones',
                    'data' => $recepciones->pluck('total')->toArray(),
                    'borderColor' => '#056C8E',
                    'backgroundColor' => 'rgba(5, 108, 142, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#116D64',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
            ],
            'labels' => $recepciones->pluck('mes')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}