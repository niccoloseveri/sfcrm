<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieraCustomerResource\Pages;
use App\Filament\Resources\FieraCustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\FieraCustomer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieraCustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel="Cliente Fiera";
    protected static ?string $pluralModelLabel="Clienti Fiera";


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('settore', function (Builder $query){
            $query->where('name', 'like','fiera');
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListFieraCustomers::route('/'),
            'create' => Pages\CreateFieraCustomer::route('/create'),
            'edit' => Pages\EditFieraCustomer::route('/{record}/edit'),
        ];
    }
}
