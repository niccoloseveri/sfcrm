<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(!auth()->user()->isAdmin()){
            $data['employee_id'] = auth()->user()->id;
        }
        return $data;
    }

    /*protected function getRedirectUrl(): string
    {
        //$response = $this->getResource()::getUrl('index');
        //if(auth()->user()->isAdmin())
        $response = $this->getResource()::getUrl('view');
        return $response;
    }
    */
}
