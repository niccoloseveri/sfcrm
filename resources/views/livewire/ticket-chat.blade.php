<div wire:poll.5s class="mt-6">
    <div class="space-y-2 max-h-64 overflow-y-auto mb-4">
        @foreach($messages as $message)
            <div class="p-3 rounded {{ $message->is_staff ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800' }}">
                <strong>{{ $message->is_staff ? 'Supporto' : 'Cliente' }}:</strong>
                <div>{{ $message->message }}</div>
            </div>
        @endforeach
    </div>
    <form wire:submit.prevent="sendMessage" class="flex gap-2">
        <textarea wire:model.defer="newMessage" class="flex-1 rounded border-gray-300" rows="2"></textarea>
        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Invia</button>
    </form>
</div>
