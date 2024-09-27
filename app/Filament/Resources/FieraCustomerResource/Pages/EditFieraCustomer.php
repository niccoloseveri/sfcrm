<?php

namespace App\Filament\Resources\FieraCustomerResource\Pages;

use App\Filament\Resources\FieraCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFieraCustomer extends EditRecord
{
    protected static string $resource = FieraCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
