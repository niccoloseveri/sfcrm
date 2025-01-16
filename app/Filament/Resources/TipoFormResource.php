<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoFormResource\Pages;
use App\Filament\Resources\TipoFormResource\RelationManagers;
use App\Models\TipoForm;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoFormResource extends Resource
{
    protected static ?string $model = TipoForm::class;

    protected static ?string $navigationGroup = 'Impostazioni';
    protected static ?string $modelLabel="Tipo Form";
    protected static ?string $pluralModelLabel="Tipi Form";
    protected static ?string $navigationLabel = 'Tipo Form';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->label('Nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->label('Nome')
                    ->searchable(),
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
            'index' => Pages\ListTipoForms::route('/'),
            'create' => Pages\CreateTipoForm::route('/create'),
            'edit' => Pages\EditTipoForm::route('/{record}/edit'),
        ];
    }
}
