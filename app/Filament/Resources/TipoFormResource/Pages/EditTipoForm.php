<?php

namespace App\Filament\Resources\TipoFormResource\Pages;

use App\Filament\Resources\TipoFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoForm extends EditRecord
{
    protected static string $resource = TipoFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
