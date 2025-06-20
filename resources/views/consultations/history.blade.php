{{-- resources/views/consultations/history.blade.php (Versi Elegan Baru) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Riwayat Konsultasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-md" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-50 border-l-4 border-red-400 text-red-800 p-4 rounded-md" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($consultations as $consultation)
                            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col md:flex-row justify-between items-start gap-4">
                                
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-500">
                                        {{ $consultation->user_id === auth()->id() ? 'Konsultasi dengan' : 'Pasien' }}
                                    </p>
                                    <p class="font-bold text-lg text-gray-900">
                                       {{ $consultation->user_id === auth()->id() ? $consultation->psychologist->name : $consultation->user->name }}
                                    </p>
                                    <p class="text-sm text-brand-pink mt-2 font-medium">{{ $consultation->requested_start_time->format('l, d F Y - H:i') }} ({{ $consultation->duration_minutes }} menit)</p>
                                </div>

                                <div class="flex-shrink-0 w-full md:w-auto text-left md:text-right mt-3 md:mt-0">
                                     {{-- Logika untuk menampilkan status dengan warna berbeda --}}
                                     @php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch ($consultation->status) {
                                            case 'pending_payment':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                $statusText = 'Menunggu Pembayaran';
                                                break;
                                            case 'pending_verification':
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                                $statusText = 'Menunggu Verifikasi';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'bg-green-100 text-green-800';
                                                $statusText = 'Terkonfirmasi';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-gray-200 text-gray-800';
                                                $statusText = 'Selesai';
                                                break;
                                            case 'expired':
                                            case 'cancelled':
                                            case 'payment_rejected':
                                                $statusClass = 'bg-red-100 text-red-800';
                                                $statusText = 'Dibatalkan/Gagal';
                                                break;
                                        }
                                    @endphp
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                    
                                    <div class="mt-2">
                                        {{-- Tombol Aksi berdasarkan status --}}
                                        @if($consultation->status === 'pending_payment' && $consultation->expires_at > now())
                                            <a href="{{ route('consultations.payment.create', $consultation) }}" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700">
                                                Lakukan Pembayaran
                                            </a>
                                        @elseif($consultation->status === 'confirmed')
                                            {{-- Nanti bisa ditambahkan link ke ruang chat di sini --}}
                                            <a href="{{ route('chat.show', $consultation) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                               Masuk Ruang Chat
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="border border-gray-200 p-12 rounded-lg text-center">
                                <p class="text-gray-500">
                                   @if(Auth::user()->role === 'admin')
                                        Tidak ada riwayat konsultasi untuk ditampilkan.
                                   @elseif(Auth::user()->role === 'psikolog')
                                        Anda belum memiliki riwayat konsultasi dengan pasien.
                                   @else
                                        Anda belum memiliki riwayat konsultasi.
                                        <a href="{{ route('consultations.index') }}" class="text-brand-pink hover:underline mt-2 inline-block font-semibold">Mulai cari psikolog sekarang</a>
                                   @endif
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>