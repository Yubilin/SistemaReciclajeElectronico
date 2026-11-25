<?php

namespace App\Filament\Widgets;

use App\Models\Recepcion;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RecepcionesRecientesChart extends ChartWidget
{
    protected static ?string $heading = 'Recepciones por Mes';

    protected function getData(): array
    {
        // ✅ Consulta compatible con PostgreSQL usando TO_CHAR
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
                    'borderColor' => '#056C8E', // Color Cerulean de tu paleta
                    'backgroundColor' => 'rgba(5, 108, 142, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
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