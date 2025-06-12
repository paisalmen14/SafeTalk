<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Pembayaran Membership') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Transfer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($confirmations as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ asset('storage/' . $item->proof_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-4">
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ route('admin.memberships.approve', $item) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui pembayaran ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                                            </form>

                                            {{-- Tombol Tolak yang memanggil modal --}}
                                            <x-danger-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'reject-confirmation-{{ $item->id }}')"
                                            >{{ __('Tolak') }}</x-danger-button>
                                        </td>
                                    </tr>

                                    {{-- Modal untuk menolak pembayaran --}}
                                    <x-modal name="reject-confirmation-{{ $item->id }}" focusable>
                                        <form method="post" action="{{ route('admin.memberships.reject', $item) }}" class="p-6">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Tolak Konfirmasi Pembayaran?') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('Harap berikan alasan penolakan. Alasan ini akan dapat dilihat oleh pengguna.') }}
                                            </p>

                                            <div class="mt-6">
                                                <x-input-label for="admin_notes" value="{{ __('Alasan Penolakan') }}" />
                                                <textarea id="admin_notes" name="admin_notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Contoh: Bukti transfer tidak valid." required></textarea>
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
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada konfirmasi pembayaran yang pending.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $confirmations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>