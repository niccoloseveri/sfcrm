<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalTrainerDateResource\Pages;
use App\Filament\Resources\PersonalTrainerDateResource\RelationManagers;
use App\Models\Customer;
use App\Models\PersonalTrainerDate;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonalTrainerDateResource extends Resource
{
    protected static ?string $model = PersonalTrainerDate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel="Appuntamento PT";
    protected static ?string $pluralModelLabel="Appuntamenti PT";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            Forms\Components\Select::make('user_id')->label('Personal Trainer')
                ->preload()
                ->searchable()
                ->relationship('employee', 'name', fn (Builder $query) => $query->whereHas('role', fn (Builder $query) => $query->where('name','like','personal trainer'))),


            Forms\Components\RichEditor::make('description')->label('Descrizione')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),

            Forms\Components\Select::make('status')->label('Stato')
                ->options([
                    'cancellato' => 'Cancellato',
                    'rinviato' => 'Rinviato',
                    'completato' => 'Completato',
            ])
            ->live(),


            /*Forms\Components\Toggle::make('is_completed')->label('Fatto?')
                    ->accepted(fn (Get $get) => $get('status')=='completato')
                    ->live()
*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                   /* ToggleIconColumn::make('is_completed')->label('Completo?')
                    ->sortable()
                    ->alignCenter()
                    ->onColor('success')
                    ->offColor('danger'),
                    */
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPersonalTrainerDates::route('/'),
            'create' => Pages\CreatePersonalTrainerDate::route('/create'),
            'edit' => Pages\EditPersonalTrainerDate::route('/{record}/edit'),
        ];
    }
}
