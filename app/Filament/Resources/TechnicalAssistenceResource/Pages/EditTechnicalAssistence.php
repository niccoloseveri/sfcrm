<?php

namespace App\Filament\Resources\TechnicalAssistenceResource\Pages;

use App\Filament\Resources\TechnicalAssistenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechnicalAssistence extends EditRecord
{
    protected static string $resource = TechnicalAssistenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
