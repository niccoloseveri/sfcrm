<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;
    //protected ?string $subheading = 'Caricamento documenti disabilitato.';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($data['same_as_fatt'] == true){
            $data['stato_c'] = $data['stato_f'];
            $data['prov_c'] = $data['prov_f'];
            $data['citta_c'] = $data['citta_f'];
            $data['cap_c'] = $data['cap_f'];
            $data['via_c'] = $data['via_f'];
        }

        return $data;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
