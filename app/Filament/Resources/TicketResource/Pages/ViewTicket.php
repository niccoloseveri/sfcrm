<?php
namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\Page;
use App\Models\Ticket;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.view-ticket';

    public Ticket $ticket;

    public function mount(string | int | Model $record): void
    {
        parent::mount($record);

        $this->ticket = $this->record;
    }

    /*public function mount($record): void
    {
        $this->record = Ticket::findOrFail($record);
    }*/


    protected function getHeaderActions(): array
    {
        return [
            // change priority - seleziona tra alta media e bassa. 2 opzioni disponibili, 1 già selezionata
            Action::make('priority')
                ->label('Cambia Priorità')
                ->color('primary')
                ->action(function (Ticket $record) {

                    //$this->notify('success', 'Priorità cambiata con successo');
                })
                ->requiresConfirmation()
                ->modalHeading('Cambia Priorità')
                ->hidden(),

            Action::make('close')->label('Chiudi Ticket')->color('warning')
                ->visible(fn ($record) => $record->status !== 'CHIUSO')
                ->action(function (Ticket $record) {
                    $record->update(['status' => 'CHIUSO']);
                    //Mail
                    //$this->notify('success', 'Ticket chiuso con successo');
                    Notification::make()
                    ->title('Ticket chiuso con successo')
                    ->success()
                    ->duration(3000)
                    ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Chiudi Ticket'),
            Action::make('reopen')->label('Riapri Ticket')->color('success')
                ->visible(fn ($record) => $record->status === 'CHIUSO')
                ->action(function (Ticket $record) {
                    $record->update(['status' => 'APERTO']);
                    //$this->notify('success', 'Ticket riaperto con successo');
                    Notification::make()
                    ->title('Ticket riaperto con successo')
                    ->success()
                    ->duration(3000)
                    ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Riapri Ticket'),
            DeleteAction::make()
                ->label('Elimina Ticket')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Elimina Ticket'),
        ];
    }
}
