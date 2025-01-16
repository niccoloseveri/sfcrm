<?php

namespace App\Filament\Resources\TipoFormResource\Pages;

use App\Filament\Resources\TipoFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoForms extends ListRecords
{
    protected static string $resource = TipoFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
