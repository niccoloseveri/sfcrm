<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskCategoryResource\Pages;
use App\Filament\Resources\TaskCategoryResource\RelationManagers;
use App\Models\TaskCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskCategoryResource extends Resource
{
    protected static ?string $model = TaskCategory::class;

    protected static ?string $navigationGroup = 'Impostazioni';
    protected static ?string $modelLabel="Categoria Task";
    protected static ?string $pluralModelLabel="Categorie Tasks";
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')->label('Descrizione')->autosize(),

                Forms\Components\ColorPicker::make('color')->label('Colore')
            ])->columns();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\ColorColumn::make('color')->label('Colore'),
                Tables\Columns\TextColumn::make('tasks_count')->label('N. Tasks')->counts('tasks'),

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
            'index' => Pages\ListTaskCategories::route('/'),
            'create' => Pages\CreateTaskCategory::route('/create'),
            'edit' => Pages\EditTaskCategory::route('/{record}/edit'),
        ];
    }
}
