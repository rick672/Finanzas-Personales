<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;

class IngresosChart extends ChartWidget
{
    protected static ?string $heading = 'Reporte de Ingresos';
    
    protected function getData(): array
    {
        $data = Movimiento::where('tipo', 'ingreso')
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
                    'label' => 'Ingresos',
                    'data' => $totalRevenue,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
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
