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
            ImportColumn::make('first_name')->exampleHeader('Nome')
                ->rules(['max:255']),
            ImportColumn::make('last_name')->exampleHeader('Cognome')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
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

    public function resolveRecord(): ?Customer
    {
        // return Customer::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Customer();
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
