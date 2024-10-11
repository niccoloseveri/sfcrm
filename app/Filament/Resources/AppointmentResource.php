<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Customer;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel="Appuntamento";
    protected static ?string $pluralModelLabel="Appuntamenti";
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup="Clienti";


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\DatePicker::make('due_date')->label('Data Appuntamento'),
            Forms\Components\TimePicker::make('due_time')->label('Ora Appuntamento'),

            Forms\Components\Select::make('customer_id')->label('Cliente')
                ->searchable()
                ->relationship('customer')
                ->getOptionLabelFromRecordUsing(function (Customer $record){
                    if($record->is_azienda){
                        $r = $record->nome_az;
                    } else $r = $record->first_name . ' ' . $record->last_name;
                    return $r;
                })
                ->preload()
                ->searchable(['first_name', 'last_name', 'nome_az'])
                ->required(),
            Forms\Components\Select::make('user_id')->label('Commerciale')
                ->preload()
                ->searchable()
                ->relationship('employee', 'name'),


            Forms\Components\RichEditor::make('description')->label('Descrizione')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),


            Forms\Components\Toggle::make('is_completed')->label('Fatto?')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ToggleIconColumn::make('is_completed')->label('Completo?')
            ->sortable()
            ->alignCenter()
            ->onColor('success')
            ->offColor('danger'),
            Tables\Columns\TextColumn::make('due_date')->label('Data Appuntamento')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('due_time')->label('Ora Appuntamento')
                ->time()
                ->sortable(),
            Tables\Columns\TextColumn::make('customer.first_name')->label('Cliente')
                ->formatStateUsing(function ($record) {
                    if($record->customer->is_azienda){
                        $r = $record->customer->nome_az;
                    } else $r = $record->customer->first_name . ' ' . $record->customer->last_name;
                    return $r;
                })
                ->searchable(['first_name', 'last_name'])
                ->sortable(),
            Tables\Columns\TextColumn::make('employee.name')->label('Impiegato')
                ->searchable()
                ->sortable()
                ->hidden(!auth()->user()->isAdmin()),
            Tables\Columns\TextColumn::make('description')->label('Descrizione')
                ->html(),


            Tables\Columns\TextColumn::make('created_at')->label('Creato')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')->label('Modificato')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Complete')->label('Completa')
                    ->hidden(fn (Appointment $record) => $record->is_completed)
                    ->icon('heroicon-m-check-badge')
                    ->modalHeading('Appuntamento finito?')
                    ->modalDescription("Sei sicuro di vole contrassegnare l'appuntamento come finito?")
                    ->action(function (Appointment $record) {
                        $record->is_completed = true;
                        $record->save();

                        Notification::make()
                            ->title('Appuntamento completato.')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                //]),
            ])
            ->defaultSort(function ($query) {
                return $query->orderBy('due_date', 'desc')
                    ->orderBy('id', 'desc');
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
