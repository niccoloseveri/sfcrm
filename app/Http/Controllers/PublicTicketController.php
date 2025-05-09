<?php

namespace App\Http\Controllers;

use App\Mail\NewTicket;
use App\Mail\NewTicketAdmin;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicTicketController extends Controller
{
    //
    public function create() {
        return view('tickets.create');
    }

    public function store(Request $request) {
        /*$data = $request->request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required',
            'email' => 'required|email',
            'priority' => 'required|in:alta,media,bassa',
        ]);*/
        //dd('CIAO');
        $data=$request->request->all();
        $ticket = Ticket::create($data);
        $mails=User::where('accepts_tickets', true)->get();

        Mail::to($ticket->email)->send(new NewTicket($ticket));
        Mail::to($mails)->send(new NewTicketAdmin($ticket));

        return redirect()->route('tickets.view', $ticket->token);
    }

    public function view(Ticket $ticketId, $token) {
        $ticket = Ticket::where('token', $token)->firstOrFail();
        return view('tickets.view', compact('ticket'));

    }
}
