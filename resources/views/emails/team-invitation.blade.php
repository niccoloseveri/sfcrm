<x-mail::message>
    Sei stato invitato a entrare in {{ config('app.name') }}

    Per accettare l'invito - clicca sul bottone qua sotto e crea un profilo:

    <x-mail::button :url="$acceptUrl">
        {{ __('Crea Account') }}
    </x-mail::button>

    {{ __("Se non aspettavi una mail da parte nostra o non ne conosci la provenienza, ingora pure l'intero messaggio.") }}
</x-mail::message>
