<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    function getRedirectUrl(): string
    {
        $response = $this->getResource()::getUrl('index');
        if(auth()->user()->isAdmin()) $response = $this->getResource()::getUrl('view');
        return $response;
    }
}
