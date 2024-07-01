<?php

namespace App\Filament\Resources\SettoreResource\Pages;

use App\Filament\Resources\SettoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettores extends ListRecords
{
    protected static string $resource = SettoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
