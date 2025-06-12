<x-guest-layout>
    <form method="POST" action="{{ route('psychologist.register') }}" enctype="multipart/form-data">
        @csrf

        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-4">Pendaftaran Psikolog</h2>
        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-6">Lengkapi data diri dan profesional Anda.</p>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 pt-4 border-t">
             <x-input-label for="ktp_number" :value="__('Nomor KTP')" />
            <x-text-input id="ktp_number" class="block mt-1 w-full" type="text" name="ktp_number" :value="old('ktp_number')" required />
            <x-input-error :messages="$errors->get('ktp_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ktp_image" :value="__('Foto KTP (JPG, PNG)')" />
            <input id="ktp_image" name="ktp_image" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required />
            <x-input-error :messages="$errors->get('ktp_image')" class="mt-2" />
        </div>

        <div class="mt-4">
             <x-input-label for="university" :value="__('Lulusan Universitas')" />
            <x-text-input id="university" class="block mt-1 w-full" type="text" name="university" :value="old('university')" required />
            <x-input-error :messages="$errors->get('university')" class="mt-2" />
        </div>

         <div class="mt-4">
             <x-input-label for="graduation_year" :value="__('Tahun Lulus')" />
            <x-text-input id="graduation_year" class="block mt-1 w-full" type="number" name="graduation_year" :value="old('graduation_year')" required />
            <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="certificate" :value="__('Scan Ijazah atau Sertifikat (PDF, JPG, PNG)')" />
            <input id="certificate" name="certificate" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required />
            <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
        </div>

        <div class="mt-4 pt-4 border-t">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar sebagai Psikolog') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>