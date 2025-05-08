@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-2xl font-bold mb-2">{{ $ticket->subject }}</h2>
    <p class="mb-1"><span class="font-semibold">Stato:</span> {{ ucfirst($ticket->status) }}</p>
    <p class="mb-1"><span class="font-semibold">Priorità:</span> {{ ucfirst($ticket->priority) }}</p>
    <div class="my-4 border p-4 rounded text-gray-700 bg-gray-50">
        {{ $ticket->description }}
    </div>
    <livewire:ticket-chat :ticket="$ticket" />
</div>
@endsection
