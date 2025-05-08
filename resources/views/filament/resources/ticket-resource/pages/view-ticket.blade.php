<x-filament-panels::page>

        <div class="space-y-6">
            <div class="bg-white shadow rounded-xl p-6 space-y-2">
                <h2 class="text-xl font-bold">Ticket #{{ $record->ticket_number }}</h2>
                <p><strong>Subject:</strong> {{ $record->subject }}</p>
                <p><strong>Email:</strong> {{ $record->email }}</p>
                <p><strong>Status:</strong> {{ ucfirst($record->status) }}</p>
                <p><strong>Priority:</strong> {{ ucfirst($record->priority) }}</p>
                <p class="pt-4 border-t"><strong>Description:</strong></p>
                <div class="text-gray-700 whitespace-pre-line">{{ $record->description }}</div>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <livewire:ticket-chat :ticket="$record" key="{{ $record->id }}" />
            </div>
        </div>


</x-filament-panels::page>
