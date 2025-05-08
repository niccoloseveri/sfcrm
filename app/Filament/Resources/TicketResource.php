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
            Tables\Columns\TextColumn::make('ticket_no')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('subject')->searchable(),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('priority')->colors([
                'success' => 'low',
                'warning' => 'medium',
                'danger' => 'high',
            ])->badge(),
            Tables\Columns\TextColumn::make('status')->colors([
                'success' => 'open',
                'secondary' => 'closed',
            ])->badge(),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
