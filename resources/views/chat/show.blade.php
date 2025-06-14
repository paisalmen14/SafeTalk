<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            Chat dengan {{ $contact->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col" style="height: 75vh;">
                    
                    {{-- Kotak Pesan --}}
                    <div id="chat-box" class="flex-grow space-y-4 overflow-y-auto p-4 border border-slate-700 rounded-md mb-4 bg-slate-900">
                        @forelse ($messages as $message)
                            <div class="flex @if($message->sender_id == Auth::id()) justify-end @else justify-start @endif">
                                <div class="max-w-xs md:max-w-lg rounded-lg p-3 @if($message->sender_id == Auth::id()) bg-cyan-600 text-white @else bg-slate-700 text-slate-200 @endif">
                                    <p class="text-sm" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    <p class="text-xs opacity-75 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                             <div class="text-center text-slate-500 h-full flex items-center justify-center">
                                Mulai percakapan Anda dengan {{ $contact->name }}.
                            </div>
                        @endforelse
                    </div>

                    {{-- =================================================== --}}
                    {{-- AWAL MODIFIKASI FORM --}}
                    {{-- =================================================== --}}

                    {{-- Tampilkan form hanya jika sesi TIDAK diarsipkan/berakhir --}}
                    @if(isset($isArchived) && $isArchived)
                        <div class="text-center p-4 bg-slate-900 border border-slate-700 rounded-md text-slate-400">
                            Sesi ini telah berakhir. Anda hanya dapat melihat riwayat percakapan.
                        </div>
                    @else
                        <form action="{{ route('chat.store', $consultation) }}" method="POST">
                            @csrf
                            <div class="flex space-x-2">
                                <x-text-input name="message" class="flex-grow" placeholder="Ketik pesan..." required autocomplete="off" />
                                <x-primary-button type="submit">Kirim</x-primary-button>
                            </div>
                            @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </form>
                    @endif
                    
                    {{-- =================================================== --}}
                    {{-- AKHIR MODIFIKASI FORM --}}
                    {{-- =================================================== --}}
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto scroll ke pesan terbaru saat halaman dimuat
        const chatBox = document.getElementById('chat-box');
        if(chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</x-app-layout>