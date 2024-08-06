<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ScheduleStatus: string implements HasColor, HasLabel
{
    case Scheduled = 'scheduled';
    case Cancelled = 'canceled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Scheduled => 'Agendado',
            self::Cancelled => 'Cancelado',
        };
    }

    public function getColor():string | array | null
    {
        return match ($this) {
            self::Scheduled => 'success',
            self::Cancelled => 'danger',
        };
    }
}
