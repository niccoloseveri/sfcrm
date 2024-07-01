<?php

namespace App\Filament\Resources\SettoreResource\Pages;

use App\Filament\Resources\SettoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettore extends EditRecord
{
    protected static string $resource = SettoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
