<?php

namespace App\Filament\Resources\FieraCustomerResource\Pages;

use App\Filament\Imports\CustomerImporter;
use App\Filament\Resources\FieraCustomerResource;
use App\Imports\Customer;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListFieraCustomers extends ListRecords
{
    protected static string $resource = FieraCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make('Importa')->importer(CustomerImporter::class)->label('Importa')->modalHeading('Importa Clienti')->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
