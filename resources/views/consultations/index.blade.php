<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Pilih Psikolog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($psychologists as $psychologist)
                    <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <div class="p-6 text-slate-100 flex-grow">
                           
                           {{-- Tampilkan Foto Profil --}}
                           @if($psychologist->psychologistProfile?->profile_image_path)
                                <img src="{{ asset('storage/' . $psychologist->psychologistProfile->profile_image_path) }}" alt="{{ $psychologist->name }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4">
                           @else
                                <div class="w-24 h-24 rounded-full bg-slate-700 mx-auto mb-4 flex items-center justify-center text-slate-400">
                                    <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                </div>
                           @endif

                           <h3 class="text-xl font-bold text-center text-white">{{ $psychologist->name }}</h3>
                           <p class="text-sm text-center text-cyan-400">{{ $psychologist->psychologistProfile->specialization ?? 'Psikolog Umum' }}</p>
                           
                           <div class="mt-4 pt-4 border-t border-slate-700 text-center">
                               <p class="text-slate-400">Mulai dari</p>
                               <p class="text-2xl font-bold text-white">Rp{{ number_format($psychologist->psychologistProfile->price_per_hour ?? 0, 0, ',', '.') }}/jam</p>
                           </div>
                        </div>
                        <div class="p-6 pt-0">
                           <a href="{{ route('consultations.psychologist.show', $psychologist) }}" class="w-full text-center inline-block bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-2 px-4 rounded">
                               Lihat Profil & Jadwal
                           </a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 col-span-3 text-center">Saat ini tidak ada psikolog yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>