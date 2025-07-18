<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios', User::count())
                ->description('Total de usuarios registrados')
                ->icon('heroicon-o-users')
                ->color('success')
                ->chart([1,2,3,8,2,10,5,4,3,1]),
            Stat::make('Categorias', Categoria::count())
                ->description('Total de categorias registradas')
                ->icon('heroicon-o-briefcase')
                ->color('primary')
                ->chart([1,2,3,8,2,10,5,4,3,1]),
            Stat::make('Movimientos', Movimiento::where('tipo', 'ingreso')->sum('monto'). ' Bs.')
                ->description('Total de ingresos registrados')
                ->icon('heroicon-o-currency-dollar')
                ->color('danger')
                ->chart([1,2,3,8,2,10,5,4,3,1]),
        ];
    }
}
