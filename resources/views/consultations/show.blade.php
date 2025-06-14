<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            Reservasi dengan {{ $psychologist->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 p-8 rounded-lg shadow-sm">
                <h3 class="text-2xl font-bold text-white">Buat Jadwal Konsultasi</h3>
                <p class="text-slate-400 mt-1">Pilih tanggal, waktu, dan durasi sesi Anda.</p>
                
                <form action="{{ route('consultations.reserve') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="psychologist_id" value="{{ $psychologist->id }}">
                    
                    <div>
                        <x-input-label for="requested_start_time" value="Pilih Tanggal & Waktu" />
                        {{-- Idealnya, ini adalah komponen kalender/jadwal yang interaktif --}}
                        <select name="requested_start_time" id="requested_start_time" class="block w-full mt-1 border-slate-600 bg-slate-900 text-slate-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Slot Waktu --</option>
                            @foreach($availableSlots as $slot)
                                <option value="{{ $slot->start_time->toDateTimeString() }}">
                                    {{ $slot->start_time->format('l, d M Y, H:i') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="duration_minutes" value="Pilih Durasi Sesi" />
                        <select name="duration_minutes" id="duration_minutes" class="block w-full mt-1 border-slate-600 bg-slate-900 text-slate-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm" required>
                            <option value="30">30 Menit</option>
                            <option value="60">60 Menit (1 Jam)</option>
                            <option value="90">90 Menit (1.5 Jam)</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-700">
                        <x-primary-button>Lanjutkan ke Pembayaran</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>