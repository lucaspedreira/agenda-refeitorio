<?php

namespace App\Filament\Resources\CafeteriaResource\Pages;

use App\Filament\Resources\CafeteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCafeterias extends ManageRecords
{
    protected static string $resource = CafeteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
