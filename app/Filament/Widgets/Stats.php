<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Agendamentos', Schedule::count())
                ->description('Total de agendamentos')
                ->descriptionIcon('heroicon-o-calendar', IconPosition::Before),
            Stat::make('Alunos', User::count())
                ->description('Total de alunos cadastrados')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before),
        ];
    }
}
