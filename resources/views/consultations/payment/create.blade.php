<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Pembayaran Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Alert Batas Waktu Pembayaran --}}
            <div class="flex items-start p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M8.257 3.099c.636-1.21 2.373-1.21 3.009 0l5.516 10.53c.63 1.202-.283 2.62-1.505 2.62H4.246c-1.222 0-2.135-1.418-1.504-2.62l5.515-10.53zM9 14a1 1 0 112 0 1 1 0 01-2 0zm1-5a1 1 0 00-1 1v2a1 1 0 102 0V10a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-yellow-800">Segera Selesaikan Pembayaran!</p>
                    <p class="text-sm text-yellow-700 mt-1">
                        Batas waktu pembayaran Anda adalah hingga <strong class="font-semibold">{{ $consultation->expires_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }}</strong>. Reservasi akan otomatis dibatalkan jika melewati batas waktu.
                    </p>
                </div>
            </div>

            {{-- Kartu Detail Pembayaran --}}
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">
                <h3 class="font-serif text-2xl font-bold text-gray-900 mb-4">Detail Pembayaran</h3>
                <div class="space-y-4 text-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-base">Total Tagihan:</span>
                        <span class="font-bold text-2xl text-brand-pink">Rp{{ number_format($consultation->total_payment, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-500 text-right -mt-2">(Termasuk biaya platform 5%)</p>
                    
                    <div class="border-t border-gray-200 my-4"></div>

                    <p class="text-base font-medium">Silakan transfer ke rekening berikut:</p>
                    <div class="bg-slate-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-lg font-bold text-gray-800">BCA: 123-456-7890</p>
                        <p class="text-base text-gray-600">a.n. PT SafeTalk Indonesia</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Konfirmasi Pembayaran --}}
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">
                 <h3 class="font-serif text-2xl font-bold text-gray-900 mb-4">Konfirmasi Pembayaran</h3>
                 <form action="{{ route('consultations.payment.store', $consultation) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                     <div>
                        @php
                           $inputClasses = 'mt-1 block w-full bg-slate-50 border-gray-300 text-black focus:border-brand-pink focus:ring-brand-pink rounded-md shadow-sm';
                        @endphp
                        <x-input-label for="amount" value="Jumlah yang Ditransfer" class="font-semibold" />
                        <input id="amount" name="amount" type="number" class="{{ $inputClasses }}" value="{{ $consultation->total_payment }}" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                     <div>
                        <x-input-label for="proof" value="Unggah Bukti Transfer (JPG, PNG)" class="font-semibold"/>
                        <input id="proof" name="proof" type="file" class="block w-full text-sm text-gray-700 mt-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-brand-pink hover:file:bg-pink-100" required />
                        <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                    </div>
                    <div class="pt-2 text-right">
                        <button type="submit" class="inline-flex items-center px-6 py-3 brand-gradient text-white font-semibold rounded-full shadow-sm hover:opacity-90 transition-all transform hover:scale-105">
                            Kirim Konfirmasi
                        </button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</x-app-layout>