<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettoreResource\Pages;
use App\Filament\Resources\SettoreResource\RelationManagers;
use App\Models\Settore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettoreResource extends Resource
{
    protected static ?string $model = Settore::class;

    protected static ?string $navigationGroup = 'Impostazioni';
    protected static ?string $modelLabel="Tipologia Azienda";
    protected static ?string $pluralModelLabel="Tipologie Aziende";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required(),
                Forms\Components\Textarea::make('description')->label('Descrizione')->autosize(),

                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->label('Nome'),
                TextColumn::make('description')->label('Descrizione')->default('–'),
                TextColumn::make('customers_count')->label('N. Clienti')->counts('customers')
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
            'index' => Pages\ListSettores::route('/'),
            'create' => Pages\CreateSettore::route('/create'),
            'edit' => Pages\EditSettore::route('/{record}/edit'),
        ];
    }
}
