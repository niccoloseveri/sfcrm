<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnicalAssistenceResource\Pages;
use App\Filament\Resources\TechnicalAssistenceResource\RelationManagers;
use App\Models\Customer;
use App\Models\TechnicalAssistence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnicalAssistenceResource extends Resource
{
    protected static ?string $model = TechnicalAssistence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel="Richiesta di Assistenza";
    protected static ?string $pluralModelLabel="Richieste di Assistenza";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\DatePicker::make('due_date')->label('Data Assistenza'),
            Forms\Components\TimePicker::make('due_time')->label('Ora Assisteza'),

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
            Forms\Components\Select::make('user_id')->label('Assistente')
                ->preload()
                ->searchable()
                ->relationship('assistente', 'name', fn (Builder $query) => $query->whereHas('role', fn (Builder $query) => $query->where('name','like','assistente'))),


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
                //
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
            'index' => Pages\ListTechnicalAssistences::route('/'),
            'create' => Pages\CreateTechnicalAssistence::route('/create'),
            'edit' => Pages\EditTechnicalAssistence::route('/{record}/edit'),
        ];
    }
}
