<?php

namespace App\Filament\Resources\FieraCustomerResource\Pages;

use App\Filament\Resources\FieraCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFieraCustomer extends CreateRecord
{
    protected static string $resource = FieraCustomerResource::class;

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
