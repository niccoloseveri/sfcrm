<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Helpdesk';
    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'ticket';

    protected static ?string $label = 'Ticket';

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('ticket_no')->sortable()->searchable()->label('N. Ticket'),
            Tables\Columns\TextColumn::make('subject')->searchable()->label('Cliente'),
            Tables\Columns\TextColumn::make('email')->searchable()->label('Email'),
            Tables\Columns\TextColumn::make('priority')->badge()->colors([
                'success' => 'bassa',
                'warning' => 'media',
                'danger' => 'alta',
            ])->sortable()->label('Priorità'),
            Tables\Columns\TextColumn::make('status')->colors([
                'success' => 'APERTO',
                'danger' => 'CHIUSO',
            ])->badge()->sortable()->label('Stato'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il'),
        ])->filters([])
          ->actions([
              Tables\Actions\ViewAction::make(),
              //Tables\Actions\EditAction::make(),
          ])
          ->bulkActions([
              Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTickets::route('/'),

            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
