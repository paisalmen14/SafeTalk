<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pendaftar Psikolog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama & Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Profesional</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($psychologists as $p)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $p->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $p->email }}</div>
                                            <div class="text-xs text-gray-400">Daftar: {{ $p->created_at->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div><strong>No. KTP:</strong> {{ $p->psychologistProfile->ktp_number ?? 'N/A' }}</div>
                                            <div><strong>Lulusan:</strong> {{ $p->psychologistProfile->university ?? 'N/A' }} ({{$p->psychologistProfile->graduation_year ?? 'N/A'}})</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex flex-col space-y-1">
                                                @if($p->psychologistProfile?->ktp_path)
                                                    <a href="{{ asset('storage/' . $p->psychologistProfile->ktp_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat KTP</a>
                                                @endif
                                                @if($p->psychologistProfile?->certificate_path)
                                                    <a href="{{ asset('storage/' . $p->psychologistProfile->certificate_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Ijazah</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-4">
                                            {{-- [PERBAIKAN] Kode untuk tombol aksi --}}
                                            <form action="{{ route('admin.psychologists.approve', $p) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui pendaftar ini sebagai psikolog?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.psychologists.reject', $p) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak pendaftar ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pendaftar psikolog baru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $psychologists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>