<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f172a">

        <title>SafeTalk - Ruang Aman untuk Berbagi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @tailwind base;
            @tailwind components;
            @tailwind utilities;

            /* Efek "glow" yang elegan untuk ikon fitur */
            .feature-icon {
                @apply bg-cyan-400/10 text-cyan-400;
            }
        </style>
    </head>
    {{-- Latar belakang biru slate gelap yang profesional --}}
    <body class="antialiased font-sans bg-slate-900">
        <div class="text-slate-300">

            {{-- =================================================================== --}}
            {{-- AWAL BAGIAN YANG DIMODIFIKASI --}}
            {{-- =================================================================== --}}
            <nav x-data="{ open: false }" class="bg-slate-900/60 backdrop-blur-sm border-b border-slate-700/50 fixed w-full z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}">
                                    <x-application-logo class="block h-12 w-auto fill-current text-slate-200" />
                                </a>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                             @if (Route::has('login'))
                                <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                     @auth
                                        <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-300 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-cyan-500">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="font-semibold text-slate-300 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-cyan-500">Log in</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="font-semibold text-slate-300 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-cyan-500">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-700 focus:outline-none focus:bg-slate-700 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @auth
                            <x-responsive-nav-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                        @else
                             <x-responsive-nav-link :href="route('login')">
                                {{ __('Log in') }}
                            </x-responsive-nav-link>
                            @if (Route::has('register'))
                                <x-responsive-nav-link :href="route('register')">
                                    {{ __('Register') }}
                                </x-responsive-nav-link>
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>
            {{-- =================================================================== --}}
            {{-- AKHIR BAGIAN YANG DIMODIFIKASI --}}
            {{-- =================================================================== --}}


            <main>
                <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8" style="background-image: url('https://images.unsplash.com/photo-1626783658527-d7355850e35d?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
                    {{-- Overlay gelap untuk meningkatkan keterbacaan teks --}}
                    <div class="absolute inset-0 bg-slate-900/70"></div>
                    
                    <div class="relative max-w-3xl mx-auto z-10">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight">
                            Anda Tidak Sendirian.
                        </h1>
                        <p class="mt-6 text-lg text-slate-300 max-w-2xl mx-auto">
                            SafeTalk adalah ruang aman untuk berbagi cerita, menemukan dukungan, dan mendapatkan pemahaman tentang kesehatan mental.
                        </p>
                        <div class="mt-8 flex justify-center gap-4 flex-wrap">
                            {{-- Tombol Aksi Utama (CTA) dengan warna cyan yang cerah dan menarik --}}
                            <a href="{{ route('register') }}" class="inline-block w-full sm:w-auto px-8 py-3 bg-cyan-500 text-white font-bold rounded-lg shadow-lg shadow-cyan-500/20 hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 ring-offset-slate-900 transition-all duration-200 ease-in-out transform hover:-translate-y-1">
                                Mulai Bergabung
                            </a>
                        </div>
                    </div>
                </section>

                <section class="py-20 bg-slate-900">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-white">Temukan Dukungan yang Anda Butuhkan</h2>
                            <p class="mt-4 text-lg text-slate-400">Jelajahi fitur-fitur yang kami sediakan untuk perjalanan Anda.</p>
                        </div>

                        <div class="mt-20 grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full feature-icon">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-white">Ruang Cerita</h3>
                                <p class="mt-2 text-slate-400">Bagikan perasaan dan pengalaman Anda secara anonim di komunitas suportif.</p>
                            </div>

                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full feature-icon">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-white">Konsultasi AI</h3>
                                <p class="mt-2 text-slate-400">Dapatkan dukungan emosional awal melalui chatbot AI kami, kapan saja.</p>
                            </div>

                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full feature-icon">
                                   <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-white">Artikel Edukatif</h3>
                                <p class="mt-2 text-slate-400">Tingkatkan pemahaman Anda melalui artikel yang ditulis oleh para ahli.</p>
                            </div>

                            <div class="text-center">
                                <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full feature-icon">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-white">Chat Profesional</h3>
                                <p class="mt-2 text-slate-400">Konsultasi langsung dengan psikolog terverifikasi via chat (premium).</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section CTA Psikolog dengan latar yang sedikit lebih terang untuk variasi --}}
                <section class="py-20 bg-slate-800">
                     <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                         <h2 class="text-3xl font-bold text-white">Apakah Anda Seorang Psikolog?</h2>
                         <p class="mt-4 text-lg text-slate-300">Bergabunglah untuk memberikan dampak positif dan menjangkau mereka yang membutuhkan uluran tangan profesional Anda.</p>
                         <div class="mt-8">
                            {{-- Tombol sekunder dengan gaya "outline" yang elegan --}}
                            <a href="{{ route('psychologist.register') }}" class="inline-block px-8 py-3 bg-transparent border-2 border-slate-600 text-slate-300 font-semibold rounded-lg hover:bg-slate-700 hover:text-white transition-colors duration-200">
                                Daftar sebagai Psikolog
                            </a>
                         </div>
                     </div>
                </section>
            </main>

            {{-- Footer yang bersih dan minimalis --}}
            <footer class="bg-slate-900 border-t border-slate-800">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <p class="text-base text-slate-400">&copy; {{ date('Y') }} SafeTalk. All rights reserved.</p>
                        <p class="mt-2 text-sm text-slate-500">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>