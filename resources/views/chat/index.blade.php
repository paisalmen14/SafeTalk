<x-app-layout>
    <x-slot name="header">
        {{-- Judul Halaman disesuaikan dengan tema --}}
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Ruang Chat Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Kontainer utama dengan background putih dan shadow elegan --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8">
                    <div class="space-y-6">
                        @forelse ($consultations as $consultation)
                            @php
                                // Tentukan siapa lawan bicara untuk ditampilkan
                                $contact = (Auth::id() === $consultation->user_id) ? $consultation->psychologist : $consultation->user;
                            @endphp
                            {{-- Kartu untuk setiap sesi konsultasi --}}
                            <a href="{{ route('chat.show', $consultation) }}" class="block p-6 rounded-2xl border border-gray-200 hover:border-pink-300 hover:bg-pink-50 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div class="flex items-center gap-4">
                                        {{-- Foto profil lawan bicara --}}
                                        @if($contact->psychologistProfile?->profile_image_path)
                                            <img src="{{ asset('storage/' . $contact->psychologistProfile->profile_image_path) }}" alt="{{ $contact->name }}" class="w-16 h-16 rounded-full object-cover">
                                        @else
                                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-lg text-gray-900">{{ $contact->name }}</div>
                                            <div class="text-sm font-medium text-pink-600">Jadwal: {{ $consultation->requested_start_time->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        {{-- Badge status sesi --}}
                                        @if(Gate::check('access-consultation-chat', $consultation))
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm font-bold text-green-800 bg-green-100 rounded-full">
                                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                                Sesi Aktif
                                            </span>
                                        @else
                                             <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-gray-600 bg-gray-100 rounded-full">
                                                Lihat Riwayat
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            {{-- Tampilan saat tidak ada sesi konsultasi --}}
                            <div class="text-center py-16 px-6">
                                <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                                <h3 class="mt-4 text-xl font-bold text-gray-800">
                                    @if(Auth::user()->role === 'psikolog')
                                        Belum Ada Sesi Terkonfirmasi
                                    @else
                                        Anda Belum Memiliki Sesi Aktif
                                    @endif
                                </h3>
                                <p class="mt-2 text-base text-gray-500">
                                     @if(Auth::user()->role === 'psikolog')
                                        Saat ada pasien yang memesan dan pembayarannya terkonfirmasi, sesi akan muncul di sini.
                                     @else
                                        Silakan buat reservasi untuk memulai sesi konsultasi dengan psikolog profesional kami.
                                     @endif
                                </p>
                                {{-- Tombol aksi khusus untuk pengguna biasa --}}
                                @if(Auth::user()->role === 'pengguna')
                                <div class="mt-6">
                                     <a href="{{ route('consultations.index') }}" class="inline-block px-6 py-3 brand-gradient text-white font-semibold rounded-full shadow-sm hover:opacity-90 transition-all transform hover:scale-105">
                                        Cari Psikolog Sekarang
                                    </a>
                                </div>
                                @endif
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>