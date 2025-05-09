@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-2xl font-bold mb-4">Apri un Ticket</h2>
    <form method="POST" action="/ticket" class="space-y-4">
        @csrf
        <label for="subject" class="block text-sm font-medium text-gray-700">Nome e Cognome:</label>
        <x-filament::input.wrapper>
            <x-filament::input type="text" name="subject" wire:model="subject" required />
        </x-filament::input.wrapper>
        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
        <x-filament::input.wrapper>
            <x-filament::input type="email" name="email" label="Your Email" wire:model="email" required />
        </x-filament::input.wrapper>
        <label for="subject" class="block text-sm font-medium text-gray-700">Descrizione problematica:</label>
        <x-filament::input.wrapper>
            <x-filament::input type="text" name="description" wire:model="description" label="Description" required />
        </x-filament::input.wrapper>

        <label for="priority" class="block text-sm font-medium text-gray-700">Priorità:</label>
        <x-filament::input.wrapper>
            <x-filament::input.select name="priority" label="Priority" wire:model="priority" required>
                <option value="bassa">Bassa</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
            </x-filament::input.select>
        </x-filament::input.wrapper>
        <x-filament::button type="submit" class="w-full">
            {{ __('Invia Ticket') }}
        </x-filament::button>
    </form>
</div>
@endsection
