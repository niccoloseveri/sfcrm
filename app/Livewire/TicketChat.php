<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class TicketChat extends Component
{

    public Ticket $ticket;
    public $newMessage='';

    protected $rules = [
        'newMessage' => 'required|string',
    ];

    public function sendMessage() {
        $this->validate();

        $message = $this->ticket->messages()->create([
            'message' => $this->newMessage,
            'is_staff' => false,
        ]);

        //Mail::to($this->ticket->email)->send(new NewTicketMessage($message));

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.ticket-chat', [
            'messages' => $this->ticket->messages()->latest()->get(),
        ]);
    }

    public function pollingInterval(){return '5s';} // Polling every 5 seconds
}
