<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Verifikasi Pembayaran Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-100">
                    @if (session('success'))
                        <div class="bg-green-500/10 border-l-4 border-green-400 text-green-300 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-700">
                            <thead class="bg-slate-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Pasien</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Psikolog</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Detail</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Bukti Bayar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-slate-800 divide-y divide-slate-700">
                                @forelse ($consultations as $consultation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-medium text-slate-100">{{ $consultation->user->name }}</div>
                                            <div class="text-slate-400">{{ $consultation->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-100">
                                            {{ $consultation->psychologist->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                            <div>Jadwal: {{ $consultation->requested_start_time->format('d M Y, H:i') }}</div>
                                            <div>Total: Rp{{ number_format($consultation->total_payment, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($consultation->paymentConfirmation)
                                                <a href="{{ asset('storage/' . $consultation->paymentConfirmation->proof_path) }}" target="_blank" class="text-cyan-400 hover:underline">
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                <span class="text-slate-500">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ route('admin.consultation.verifications.approve', $consultation) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menyetujui pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="text-green-400 hover:text-green-300">Setujui</button>
                                            </form>
                                            
                                            {{-- Tombol Tolak --}}
                                             <x-danger-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'reject-consultation-{{ $consultation->id }}')"
                                            >{{ __('Tolak') }}</x-danger-button>
                                        </td>
                                    </tr>

                                    {{-- Modal untuk menolak pembayaran --}}
                                    <x-modal name="reject-consultation-{{ $consultation->id }}" focusable>
                                        <form method="post" action="{{ route('admin.consultation.verifications.reject', $consultation) }}" class="p-6">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-100">
                                                {{ __('Tolak Konfirmasi Pembayaran?') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-400">
                                                {{ __('Harap berikan alasan penolakan. Alasan ini akan dapat dilihat oleh pengguna.') }}
                                            </p>

                                            <div class="mt-6">
                                                <x-input-label for="rejection_reason" value="{{ __('Alasan Penolakan') }}" />
                                                <textarea id="rejection_reason" name="rejection_reason" class="mt-1 block w-full border-slate-600 bg-slate-900 text-slate-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm" placeholder="Contoh: Bukti transfer tidak valid." required></textarea>
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Batal') }}
                                                </x-secondary-button>

                                                <x-danger-button class="ms-3">
                                                    {{ __('Tolak Pembayaran') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-slate-400">
                                            Tidak ada pembayaran yang perlu diverifikasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>