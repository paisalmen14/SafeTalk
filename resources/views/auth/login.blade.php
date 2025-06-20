<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Judul Form --}}
        <div class="text-center mb-8">
            <h2 class="font-serif text-3xl font-bold text-gray-900">Selamat Datang Kembali</h2>
            <p class="mt-2 text-gray-600">Silakan masuk untuk melanjutkan.</p>
        </div>

        <div>
            <x-input-label for="email" value="Email" class="font-semibold text-gray-700" />
            
            <x-text-input 
                id="email" 
                class="block mt-1 w-full bg-white border-gray-300 focus:border-brand-pink focus:ring-brand-pink text-gray-900" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
                
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-input-label for="password" value="Password" class="font-semibold text-gray-700"/>

            <x-text-input 
                id="password" 
                class="block mt-1 w-full bg-white border-gray-300 focus:border-brand-pink focus:ring-brand-pink text-gray-900" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-pink shadow-sm focus:ring-brand-pink" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-brand-pink rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-pink" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-base font-medium text-white brand-gradient hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-pink transition-all transform hover:scale-105">
                {{ __('Log In') }}
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-brand-pink hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>