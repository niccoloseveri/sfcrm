<?php

namespace App\Filament\Imports;

use App\Models\Customer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CustomerImporter extends Importer
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('gia_cliente')->exampleHeader('Già Cliente? (S/N)')
            ->rules(['max:255']),
            ImportColumn::make('first_name')->exampleHeader('Nome')
                ->rules(['max:255']),
            ImportColumn::make('last_name')->exampleHeader('Cognome')
                ->rules(['max:255']),
            ImportColumn::make('email')->exampleHeader('Email')
                ->rules(['max:255']),
            ImportColumn::make('phone_number')->exampleHeader('Telefono')
                ->rules(['max:255']),
            ImportColumn::make('description')->exampleHeader('Descrizione'),
            ImportColumn::make('citta_r')->exampleHeader('Città')
                ->rules(['max:255']),
            ImportColumn::make('prov_r')->exampleHeader('Provincia')
                ->rules(['max:255']),
            ImportColumn::make('via_r')->exampleHeader('Via')
                ->rules(['max:255']),
            ImportColumn::make('cap_r')->exampleHeader('CAP')
                ->rules(['max:255']),
            ImportColumn::make('stato_r')->exampleHeader('Stato')
                ->rules(['max:255']),
            ImportColumn::make('nome_az')->exampleHeader('Nome Azienda')
                ->rules(['max:255']),
            ImportColumn::make('cf_azienda')->exampleHeader('Codice Fiscale Az.')
                ->rules(['max:255']),
            ImportColumn::make('piva')->exampleHeader('Partita IVA')
                ->rules(['max:255']),
            ImportColumn::make('email_az')->exampleHeader('Email Az.')
                ->rules(['max:255']),
            ImportColumn::make('tel_az')->exampleHeader('Telefono Az.')
                ->rules(['max:255']),
            ImportColumn::make('website')->exampleHeader('Sito Web')
                ->rules(['max:255']),
            ImportColumn::make('cod_univoco')->exampleHeader('Codice Univoco')
                ->rules(['max:255']),
            ImportColumn::make('citta_az')->exampleHeader('Città Azienda')
                ->rules(['max:255']),
            ImportColumn::make('prov_az')->exampleHeader('Provincia Azienda')
                ->rules(['max:255']),
            ImportColumn::make('via_az')->exampleHeader('Via Azienda')
                ->rules(['max:255']),
            ImportColumn::make('cap_az')->exampleHeader('CAP Azienda')
                ->rules(['max:255']),
            ImportColumn::make('stato_az')->exampleHeader('Stato Azienda')
                ->rules(['max:255']),
            ImportColumn::make('altreinfo')->exampleHeader('Info'),
        ];
    }

    protected function beforeValidate(): void
    {
        // Runs before the CSV data for a row is validated.
        if($this->data['first_name']==''){
            $data['first_name']='xxxxx';
        }
        if($this->data['last_name']==''){
            $this->data['last_name']='xxxxx';
        }

    }

    protected function beforeCreate(): void
    {
        if($this->data['nome_az']!='' || $this->data['nome_az']!=null ){
            $this->record['is_azienda']= 1 ;
            $this->record['settore_id']= 13 ;
            $this->record['is_azienda'] == 1 ? $this->record['is_azienda'] == 1 : $this->record['is_azienda'] = true;
        }

    }

    public function resolveRecord(): ?Customer
    {
        //$u=Customer::where('email','like',$this->data['email'])->orWhere(fn ($q) => $q->where('email_az','like',$this->data['email_az']))->firstOrNew();
        //return $u;
        return Customer::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
           'email_az' => $this->data['email_az'],
        ]);

        //return new Customer();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your customer import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
