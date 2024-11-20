<x-mail::message>
    Un nuovo cliente è stato registrato in {{ config('app.name') }}<br>
    Di seguito i suoi dati:<br>
    Nome: {{$customer->first_name}}<br>
    Cognome: {{$customer->last_name}}<br>
    email: {{$customer->email}}<br>
    @if ($customer->is_azienda == true)
        Nome Azienda: {{$customer->nome_az}}<br>
        Email Azienda: {{$customer->email_az}}<br>
    @endif
    Link: {{route('filament.admin.resources.customers.view',[$customer->id])}}<br>


    {{ __("Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ingora pure il messaggio.") }}
</x-mail::message>
