<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Pengaturan Profil Psikolog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tambahkan enctype untuk form upload file --}}
            <form method="POST" action="{{ route('psychologist.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-slate-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 md:p-8 text-slate-100 space-y-6">
                        
                        {{-- Bagian Foto Profil --}}
                        <div>
                            <x-input-label for="profile_image" value="Foto Profil" />
                            <div class="mt-2 flex items-center gap-x-4">
                                @if ($profile->profile_image_path)
                                    <img src="{{ asset('storage/' . $profile->profile_image_path) }}" alt="Foto Profil" class="h-24 w-24 rounded-full object-cover">
                                @else
                                    <span class="h-24 w-24 rounded-full bg-slate-700 flex items-center justify-center text-slate-400">
                                        <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                    </span>
                                @endif
                                <input id="profile_image" name="profile_image" type="file" class="text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-700 file:text-cyan-300 hover:file:bg-slate-600"/>
                            </div>
                             <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
                        </div>

                        {{-- Bagian Harga --}}
                        <div>
                            <x-input-label for="price_per_hour" :value="__('Harga per Jam (dalam Rupiah)')" />
                            <x-text-input id="price_per_hour" name="price_per_hour" type="number" class="mt-1 block w-full md:w-1/2" :value="old('price_per_hour', $profile->price_per_hour)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price_per_hour')" />
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="bg-slate-700/50 px-6 py-4 flex items-center justify-end">
                        <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>