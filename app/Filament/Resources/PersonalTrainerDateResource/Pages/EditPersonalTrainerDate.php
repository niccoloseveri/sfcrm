<?php

namespace App\Filament\Resources\PersonalTrainerDateResource\Pages;

use App\Filament\Resources\PersonalTrainerDateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalTrainerDate extends EditRecord
{
    protected static string $resource = PersonalTrainerDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
