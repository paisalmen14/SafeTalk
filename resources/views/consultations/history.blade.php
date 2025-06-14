<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Riwayat Konsultasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-100">
                    
                    @if (session('success'))
                        <div class="bg-green-500/10 border border-green-400 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-500/10 border border-red-400 text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($consultations as $consultation)
                            <div class="p-6 bg-slate-800 border border-slate-700 rounded-lg shadow-sm flex flex-col md:flex-row justify-between items-start gap-4">
                                
                                <div class="flex-grow">
                                    <p class="text-sm text-slate-400">Psikolog</p>
                                    <p class="font-bold text-lg text-white">{{ $consultation->psychologist->name }}</p>
                                    <p class="text-sm text-cyan-400 mt-2">{{ $consultation->requested_start_time->format('l, d F Y - H:i') }} ({{ $consultation->duration_minutes }} menit)</p>
                                </div>

                                <div class="flex-shrink-0 text-center md:text-right">
                                     {{-- Logika untuk menampilkan status dengan warna berbeda --}}
                                     @php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch ($consultation->status) {
                                            case 'pending_payment':
                                                $statusClass = 'bg-yellow-500/20 text-yellow-300';
                                                $statusText = 'Menunggu Pembayaran';
                                                break;
                                            case 'pending_verification':
                                                $statusClass = 'bg-blue-500/20 text-blue-300';
                                                $statusText = 'Menunggu Verifikasi';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'bg-green-500/20 text-green-300';
                                                $statusText = 'Terkonfirmasi';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-slate-600 text-slate-300';
                                                $statusText = 'Selesai';
                                                break;
                                            case 'expired':
                                            case 'cancelled':
                                            case 'payment_rejected':
                                                $statusClass = 'bg-red-500/20 text-red-300';
                                                $statusText = 'Dibatalkan/Gagal';
                                                break;
                                        }
                                    @endphp
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                    
                                    <div class="mt-2">
                                        {{-- Tombol Aksi berdasarkan status --}}
                                        @if($consultation->status === 'pending_payment' && $consultation->expires_at > now())
                                            <a href="{{ route('consultations.payment.create', $consultation) }}">
                                                <x-primary-button>Lakukan Pembayaran</x-primary-button>
                                            </a>
                                        @elseif($consultation->status === 'confirmed')
                                            {{-- Nanti bisa ditambahkan link ke ruang chat di sini --}}
                                            <x-secondary-button disabled>Sesi Terkonfirmasi</x-secondary-button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-slate-800 border border-slate-700 p-6 rounded-lg shadow-sm text-center">
                                {{-- Tampilkan pesan berbeda berdasarkan role --}}
                                @if(Auth::user()->role === 'psikolog')
                                    <p class="text-slate-400">Anda belum memiliki riwayat konsultasi dengan pasien.</p>
                                @else
                                    <p class="text-slate-400">Anda belum memiliki riwayat konsultasi.</p>
                                    <a href="{{ route('consultations.index') }}" class="text-cyan-400 hover:underline mt-2 inline-block">Mulai cari psikolog sekarang</a>
                                @endif
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>