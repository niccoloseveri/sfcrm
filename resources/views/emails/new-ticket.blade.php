<x-mail::message>
    Un nuovo Ticket è stato creato in {{ config('app.name') }}<br>
    Di seguito i suoi dati:<br>
    Nome e Cognome: {{$ticket->subject}}<br>
    email: {{$ticket->email}}<br>
    Link: {{route('tickets.view', $ticket->token)}}

    {{ __("Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ingora pure il messaggio.") }}
</x-mail::message>
