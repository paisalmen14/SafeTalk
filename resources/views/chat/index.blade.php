<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Ruang Chat Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-100">
                    <div class="space-y-4">
                        @forelse ($consultations as $consultation)
                            @php
                                // Tentukan siapa lawan bicara untuk ditampilkan
                                $contact = (Auth::id() === $consultation->user_id) ? $consultation->psychologist : $consultation->user;
                            @endphp
                            <a href="{{ route('chat.show', $consultation) }}" class="block p-4 border border-slate-700 rounded-lg hover:bg-slate-700 transition duration-150 ease-in-out">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-semibold text-lg text-white">{{ $contact->name }}</div>
                                        <div class="text-sm text-cyan-400">Jadwal: {{ $consultation->requested_start_time->format('d M Y, H:i') }}</div>
                                    </div>
                                    <div>
                                        @if(Gate::check('access-consultation-chat', $consultation))
                                            <span class="text-sm font-bold text-green-400">SESI SEDANG BERLANGSUNG</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-slate-400 text-center py-8">
                                @if(Auth::user()->role === 'psikolog')
                                    Belum ada sesi konsultasi terkonfirmasi untuk Anda.
                                @else
                                    Anda tidak memiliki sesi konsultasi aktif. Silakan buat reservasi baru.
                                @endif
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>