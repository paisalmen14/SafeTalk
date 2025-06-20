<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Kelola Jadwal Ketersediaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Kartu untuk Menambah Jadwal Baru --}}
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="font-serif text-2xl font-bold text-gray-900 mb-1">Tambah Jadwal Baru</h3>
                <p class="text-gray-500 mb-6">Tentukan slot waktu kapan Anda bersedia untuk sesi konsultasi.</p>
                <form action="{{ route('psychologist.availability.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @php
                        $inputClasses = 'mt-1 block w-full bg-slate-50 border-gray-300 text-black focus:border-brand-pink focus:ring-brand-pink rounded-md shadow-sm';
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="start_time" :value="__('Waktu Mulai')" class="font-semibold"/>
                            <input id="start_time" type="datetime-local" name="start_time" class="{{ $inputClasses }}" required>
                             @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('Waktu Selesai')" class="font-semibold"/>
                            <input id="end_time" type="datetime-local" name="end_time" class="{{ $inputClasses }}" required>
                            @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-2 brand-gradient text-white font-semibold rounded-full shadow-sm hover:opacity-90 transition-all transform hover:scale-105">
                            + Tambah Jadwal
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kartu Daftar Jadwal yang Akan Datang --}}
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="font-serif text-2xl font-bold text-gray-900 mb-6">Jadwal Anda yang Akan Datang</h3>
                <div class="space-y-4">
                    @forelse ($availabilities as $item)
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 rounded-xl transition-all {{ $item->is_booked ? 'bg-amber-50 border-2 border-amber-300' : 'bg-gray-50 border border-gray-200' }}">
                            <div>
                                <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($item->start_time)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p class="text-base text-gray-600 font-medium">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }} WIB</p>
                            </div>
                            <div class="mt-3 sm:mt-0 flex-shrink-0">
                                @if($item->is_booked)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-bold text-amber-800 bg-amber-200 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        Dipesan
                                    </span>
                                @else
                                    <form action="{{ route('psychologist.availability.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 hover:bg-red-100 px-3 py-1 rounded-md transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        {{-- Tampilan saat jadwal kosong --}}
                        <div class="text-center py-12 px-6 border-2 border-dashed rounded-xl">
                            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <h3 class="mt-4 text-xl font-bold text-gray-800">Anda belum menambahkan jadwal</h3>
                            <p class="mt-2 text-base text-gray-500">Gunakan formulir di atas untuk membuat jadwal ketersediaan Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>