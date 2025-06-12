<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat dengan {{ $contact->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col h-[70vh]">
                    <div id="chat-box" class="flex-grow space-y-4 overflow-y-auto p-4 border rounded-md mb-4 bg-gray-50">
                        @forelse ($messages as $message)
                            <div class="flex @if($message->sender_id == Auth::id()) justify-end @else justify-start @endif">
                                <div class="max-w-xs md:max-w-md rounded-lg p-3 @if($message->sender_id == Auth::id()) bg-blue-500 text-white @else bg-gray-200 text-gray-800 @endif">
                                    <p class="text-sm" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    <p class="text-xs opacity-75 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                             <div class="text-center text-gray-500 h-full flex items-center justify-center">
                                Mulai percakapan Anda dengan {{ $contact->name }}.
                            </div>
                        @endforelse
                    </div>

                    <form action="{{ route('chat.store', $contact) }}" method="POST">
                        @csrf
                        <div class="flex space-x-2">
                            <x-text-input name="message" class="flex-grow" placeholder="Ketik pesan..." required autocomplete="off" />
                            <x-primary-button type="submit">Kirim</x-primary-button>
                        </div>
                         @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto scroll ke pesan terbaru saat halaman dimuat
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</x-app-layout>