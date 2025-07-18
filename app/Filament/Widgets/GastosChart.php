<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;

class GastosChart extends ChartWidget
{
    protected static ?string $heading = 'Reporte de Gastos';

    protected function getData(): array
    {
        $data = Movimiento::where('tipo', 'gasto')
            ->selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->get();

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $totalRevenue = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $totalRevenue[$item->mes - 1] = $item->total;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Gastos',
                    'data' => $totalRevenue,
                    'backgroundColor' => '#FF5733',
                    'borderColor' => '#FF5733',
                    'fill' => false,
                ],
            ],
            'labels' => $meses,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
