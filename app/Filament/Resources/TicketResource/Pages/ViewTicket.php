<?php
namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\Page;
use App\Models\Ticket;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.view-ticket';

    /*public function mount($record): void
    {
        $this->record = Ticket::findOrFail($record);
    }*/
}
