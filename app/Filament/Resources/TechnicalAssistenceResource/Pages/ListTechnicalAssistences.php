<?php

namespace App\Filament\Resources\TechnicalAssistenceResource\Pages;

use App\Filament\Resources\TechnicalAssistenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnicalAssistences extends ListRecords
{
    protected static string $resource = TechnicalAssistenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
