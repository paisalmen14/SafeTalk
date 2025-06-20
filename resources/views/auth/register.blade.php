<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Judul Form yang Disesuaikan --}}
        <div class="text-center mb-8">
            <h2 class="font-serif text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
            <p class="mt-2 text-gray-600">Mulailah perjalanan Anda bersama SafeTalk.</p>
        </div>

        @php
            // Definisikan kelas styling untuk input di satu tempat agar mudah diubah
            $inputClasses = 'block mt-1 w-full bg-slate-50 border-gray-300 text-black focus:border-brand-pink focus:ring-brand-pink rounded-md shadow-sm';
        @endphp

        <div class="space-y-6">
            {{-- Nama Lengkap --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-gray-900" />
                {{-- DIGANTI DARI <x-text-input> MENJADI <input> --}}
                <input id="name" class="{{ $inputClasses }}" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Username --}}
            <div>
                <x-input-label for="username" :value="__('Username')" class="font-semibold text-gray-900" />
                <input id="username" class="{{ $inputClasses }}" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-900" />
                <input id="email" class="{{ $inputClasses }}" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-900" />
                <input id="password" class="{{ $inputClasses }}" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-semibold text-gray-900" />
                <input id="password_confirmation" class="{{ $inputClasses }}" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-base font-medium text-white brand-gradient hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-pink transition-all transform hover:scale-105">
                {{ __('Daftar') }}
            </button>
        </div>

        {{-- Tautan ke Halaman Login --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-brand-pink hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>