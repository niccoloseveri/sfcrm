<x-mail::message>
    Un nuovo Ticket è stato creato in {{ config('app.name') }}<br>
    Di seguito i dati del Cliente:<br>
    Nome e Cognome: {{$ticket->subject}}<br>
    email: {{$ticket->email}}<br>
    Link: {{route('filament.admin.resources.ticket.view', $ticket)}}

    {{ __("Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ingora pure il messaggio.") }}
</x-mail::message>
