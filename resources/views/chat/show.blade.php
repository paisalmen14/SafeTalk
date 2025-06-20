<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif font-bold text-3xl text-gray-900">
                Chat dengan {{ $contact->name }}
            </h2>
             <a href="{{ route('consultations.history') }}" class="text-sm font-medium text-gray-600 hover:text-brand-pink flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Kembali ke Riwayat Konsultasi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-4 sm:p-6 flex flex-col" style="height: 75vh;">
                    
                    {{-- Kotak Pesan --}}
                    <div id="chat-box" class="flex-grow space-y-6 overflow-y-auto p-4 bg-slate-50 rounded-lg">
                        @forelse ($messages as $message)
                            <div class="flex @if($message->sender_id == Auth::id()) justify-end @else justify-start @endif">
                                <div class="max-w-md md:max-w-lg rounded-2xl px-5 py-3 shadow-sm @if($message->sender_id == Auth::id()) brand-gradient text-white @else bg-gray-200 text-gray-800 @endif">
                                    <p class="text-base" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    <p class="text-xs opacity-75 mt-2 text-right">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @empty
                             <div class="text-center text-gray-400 h-full flex flex-col items-center justify-center">
                                <svg class="h-16 w-16 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                </svg>
                                Mulai percakapan Anda dengan {{ $contact->name }}.
                            </div>
                        @endforelse
                    </div>

                    {{-- Area Input Pesan --}}
                    <div class="mt-4 flex-shrink-0">
                        @if(isset($isArchived) && $isArchived)
                            <div class="text-center p-4 bg-gray-100 border-t rounded-b-lg text-gray-600">
                                Sesi ini telah berakhir. Anda hanya dapat melihat riwayat percakapan.
                            </div>
                        @else
                            <form action="{{ route('chat.store', $consultation) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-3 p-2 border-t bg-white">
                                    @php
                                        $inputClasses = 'block w-full bg-slate-50 border-gray-200 text-black placeholder-gray-400 focus:border-brand-pink focus:ring-brand-pink rounded-full shadow-sm resize-none';
                                    @endphp
                                    <textarea name="message" class="{{ $inputClasses }}" rows="1" placeholder="Ketik pesan..." required oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"></textarea>
                                    
                                    <button type="submit" class="inline-flex items-center justify-center h-12 w-12 flex-shrink-0 rounded-full brand-gradient text-white shadow-sm hover:opacity-90 transition-all transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('message') <p class="text-red-500 text-xs mt-1 px-2">{{ $message }}</p> @enderror
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            if(chatBox) {
                // Fungsi untuk auto-scroll ke bawah
                const scrollToBottom = () => {
                    chatBox.scrollTop = chatBox.scrollHeight;
                };
                
                // Panggil saat halaman dimuat
                scrollToBottom();

                // Panggil setiap kali ada pesan baru (opsional, jika menggunakan live update)
                // const observer = new MutationObserver(scrollToBottom);
                // observer.observe(chatBox, { childList: true });
            }
        });
    </script>
</x-app-layout>