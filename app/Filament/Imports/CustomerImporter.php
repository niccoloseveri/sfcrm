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
            ImportColumn::make('first_name')
                ->rules(['max:255']),
            ImportColumn::make('last_name')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('description'),
            ImportColumn::make('gia_cliente')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('prima_fattura')
                ->rules(['date']),
            ImportColumn::make('is_azienda')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('nome_az')
                ->rules(['max:255']),
            ImportColumn::make('rag_sociale')
                ->rules(['max:255']),
            ImportColumn::make('cf_azienda')
                ->rules(['max:255']),
            ImportColumn::make('piva')
                ->rules(['max:255']),
            ImportColumn::make('email_az')
                ->rules(['email', 'max:255']),
            ImportColumn::make('tel_az')
                ->rules(['max:255']),
            ImportColumn::make('website')
                ->rules(['max:255']),
            ImportColumn::make('citta_az')
                ->rules(['max:255']),
            ImportColumn::make('prov_az')
                ->rules(['max:255']),
            ImportColumn::make('via_az')
                ->rules(['max:255']),
            ImportColumn::make('cap_az')
                ->rules(['max:255']),
            ImportColumn::make('stato_az')
                ->rules(['max:255']),
            ImportColumn::make('cod_univoco')
                ->rules(['max:255']),
            ImportColumn::make('cf')
                ->rules(['max:255']),
            ImportColumn::make('citta_r')
                ->rules(['max:255']),
            ImportColumn::make('prov_r')
                ->rules(['max:255']),
            ImportColumn::make('via_r')
                ->rules(['max:255']),
            ImportColumn::make('cap_r')
                ->rules(['max:255']),
            ImportColumn::make('stato_r')
                ->rules(['max:255']),
            ImportColumn::make('citta_c')
                ->rules(['max:255']),
            ImportColumn::make('prov_c')
                ->rules(['max:255']),
            ImportColumn::make('via_c')
                ->rules(['max:255']),
            ImportColumn::make('cap_c')
                ->rules(['max:255']),
            ImportColumn::make('stato_c')
                ->rules(['max:255']),
            ImportColumn::make('citta_f')
                ->rules(['max:255']),
            ImportColumn::make('prov_f')
                ->rules(['max:255']),
            ImportColumn::make('via_f')
                ->rules(['max:255']),
            ImportColumn::make('cap_f')
                ->rules(['max:255']),
            ImportColumn::make('stato_f')
                ->rules(['max:255']),
            ImportColumn::make('same_as_fatt')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('note_spedizione'),
            ImportColumn::make('altreinfo'),
            ImportColumn::make('settore')
                ->relationship(),
            ImportColumn::make('leadSource')
                ->relationship(),
            ImportColumn::make('pipelineStage')
                ->relationship(),
            ImportColumn::make('employee')
                ->relationship(),
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
