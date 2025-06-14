<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Kelola Jadwal Ketersediaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-slate-800 p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-slate-100">Tambah Jadwal Baru</h3>
                <form action="{{ route('psychologist.availability.store') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                            <x-text-input id="start_time" type="datetime-local" name="start_time" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                            <x-text-input id="end_time" type="datetime-local" name="end_time" class="mt-1 block w-full" required />
                        </div>
                    </div>
                    <x-primary-button>+ Tambah Jadwal</x-primary-button>
                </form>
            </div>

            <div class="bg-slate-800 p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-slate-100">Jadwal Anda yang Akan Datang</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($availabilities as $item)
                        <div class="flex justify-between items-center p-4 rounded-md {{ $item->is_booked ? 'bg-slate-900 border border-yellow-500' : 'bg-slate-700' }}">
                            <div>
                                <p class="font-semibold text-white">{{ \Carbon\Carbon::parse($item->start_time)->format('l, d M Y') }}</p>
                                <p class="text-sm text-slate-300">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</p>
                            </div>
                            @if($item->is_booked)
                                <span class="text-sm font-bold text-yellow-400">DIPESAN</span>
                            @else
                                <form action="{{ route('psychologist.availability.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Hapus</x-danger-button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-slate-400">Anda belum menambahkan jadwal.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>