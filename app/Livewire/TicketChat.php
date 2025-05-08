<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTicketMessage;

class TicketChat extends Component
{
    public Ticket $ticket;
    public string $newMessage = '';
    public bool $isStaff = false;

    protected function rules(): array
    {
        return [
            'newMessage' => 'required|string|max:2000',
        ];
    }

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;

        // Determina se è un operatore staff (autenticato nel backend)
        $this->isStaff = auth()->check(); // Puoi raffinare con un ruolo
    }

    public function sendMessage()
    {
        $this->validate();

        $message = $this->ticket->messages()->create([
            'message' => $this->newMessage,
            'is_staff' => $this->isStaff,
        ]);

        // Notifica utente solo se messaggio viene dallo staff
        /*if ($this->isStaff) {
            Mail::to($this->ticket->email)->send(new NewTicketMessage($message));
        }
        */
        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.ticket-chat', [
            'messages' => $this->ticket->messages()->oldest()->get(),
        ]);
    }

    public function pollingInterval(): string
    {
        return '5s';
    }
}
