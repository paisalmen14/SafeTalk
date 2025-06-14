<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Pembayaran Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-yellow-900/50 border border-yellow-600 text-yellow-300 p-4 rounded-lg">
                <p class="font-bold">Segera Selesaikan Pembayaran!</p>
                <p class="text-sm">Batas waktu pembayaran Anda adalah hingga {{ $consultation->expires_at->format('d M Y, H:i') }}. Reservasi akan otomatis dibatalkan jika melewati batas waktu.</p>
            </div>

            <div class="bg-slate-800 p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-slate-100">Detail Pembayaran</h3>
                <div class="mt-4 space-y-2 text-slate-300">
                    <p>Total Tagihan: <span class="font-bold text-white text-xl">Rp{{ number_format($consultation->total_payment, 0, ',', '.') }}</span></p>
                    <p class="text-sm text-slate-400">(Termasuk biaya platform 5%)</p>
                    <hr class="border-slate-700 my-4">
                    <p>Silakan transfer ke rekening berikut:</p>
                    <p><strong>BCA: 123-456-7890</strong> a.n. PT SafeTalk Indonesia</p>
                </div>
            </div>

            <div class="bg-slate-800 p-6 rounded-lg shadow-sm">
                 <h3 class="text-lg font-medium text-slate-100">Konfirmasi Pembayaran</h3>
                 <form action="{{ route('consultations.payment.store', $consultation) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf
                     <div>
                        <x-input-label for="amount" value="Jumlah yang Ditransfer" />
                        <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" :value="$consultation->total_payment" required />
                    </div>
                     <div>
                        <x-input-label for="proof" value="Unggah Bukti Transfer" />
                        <input id="proof" name="proof" type="file" class="mt-1 block w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-700 file:text-cyan-300 hover:file:bg-slate-600" required />
                    </div>
                    <x-primary-button>Kirim Konfirmasi</x-primary-button>
                 </form>
            </div>
        </div>
    </div>
</x-app-layout>