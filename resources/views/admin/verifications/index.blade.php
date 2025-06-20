{{-- resources/views/admin/verifications/index.blade.php (Versi Elegan Baru) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Verifikasi Pembayaran Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8">
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-md" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pasien</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Psikolog</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detail</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bukti Bayar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($consultations as $consultation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-medium text-gray-900">{{ $consultation->user->name }}</div>
                                            <div class="text-gray-500">{{ $consultation->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $consultation->psychologist->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div>Jadwal: {{ $consultation->requested_start_time->format('d M Y, H:i') }}</div>
                                            <div>Total: Rp{{ number_format($consultation->total_payment, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($consultation->paymentConfirmation)
                                                <a href="{{ asset('storage/' . $consultation->paymentConfirmation->proof_path) }}" target="_blank" class="font-medium text-brand-pink hover:underline">
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                <span class="text-gray-400">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ route('admin.consultation.verifications.approve', $consultation) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menyetujui pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">Setujui</button>
                                            </form>
                                            
                                            {{-- Tombol Tolak --}}
                                             <x-danger-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'reject-consultation-{{ $consultation->id }}')"
                                                class="px-3 py-1 text-xs"
                                            >{{ __('Tolak') }}</x-danger-button>
                                        </td>
                                    </tr>

                                    {{-- Modal untuk menolak pembayaran --}}
                                    <x-modal name="reject-consultation-{{ $consultation->id }}" focusable>
                                        <form method="post" action="{{ route('admin.consultation.verifications.reject', $consultation) }}" class="p-6 bg-white rounded-lg">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Tolak Konfirmasi Pembayaran?') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600">
                                                {{ __('Harap berikan alasan penolakan. Alasan ini akan dapat dilihat oleh pengguna.') }}
                                            </p>

                                            <div class="mt-6">
                                                <x-input-label for="rejection_reason" value="{{ __('Alasan Penolakan') }}" class="text-gray-800" />
                                                <textarea id="rejection_reason" name="rejection_reason" class="mt-1 block w-full border-gray-300 focus:border-brand-pink focus:ring-brand-pink rounded-md shadow-sm text-gray-900" placeholder="Contoh: Bukti transfer tidak valid." required></textarea>
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
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            Tidak ada pembayaran yang perlu diverifikasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>