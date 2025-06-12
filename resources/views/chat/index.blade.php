<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'psikolog' ? 'Daftar Percakapan' : 'Pilih Psikolog' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-4">
                        @forelse ($contacts as $contact)
                            <a href="{{ route('chat.show', $contact) }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="font-semibold text-lg">{{ $contact->name }}</div>
                                <div class="text-sm text-gray-500">
                                     @if(Auth::user()->role === 'psikolog')
                                        Pengguna Member
                                     @else
                                        Psikolog Terverifikasi
                                     @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-center py-8">
                                @if(Auth::user()->role === 'psikolog')
                                    Belum ada pengguna yang memulai percakapan dengan Anda.
                                @else
                                    Saat ini belum ada psikolog yang tersedia.
                                @endif
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>