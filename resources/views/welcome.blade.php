<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="scroll-behavior: smooth;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#E91E63">

    <title>SafeTalk - Perjalanan Menuju Ketenangan</title>

    {{-- Font Kustom --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Definisi Font Kustom */
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }

        /* PERBAIKAN: Mendefinisikan warna kustom agar bisa digunakan oleh Tailwind */
        :root {
            --brand-pink: #E91E63;
            --brand-red: #F44336;
            --brand-rose: #E91E63; /* Alias for pink */
            --brand-coral: #FF5722;
            --soft-gray: #f8fafc;
            --warm-gray: #f1f5f9;
        }
        .text-brand-pink { color: var(--brand-pink); }
        .text-brand-rose { color: var(--brand-rose); }
        .text-brand-red { color: var(--brand-red); }
        .text-brand-coral { color: var(--brand-coral); }
        .bg-brand-pink\/10 { background-color: rgba(233, 30, 99, 0.1); }
        .border-brand-pink\/20 { border-color: rgba(233, 30, 99, 0.2); }
        /* ... dan seterusnya untuk warna lain jika diperlukan ... */


        .elegant-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
        }

        .floating-shapes::before, .floating-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.8;
            filter: blur(50px);
        }
        .floating-shapes::before {
            top: 10%;
            right: 5%;
            width: 250px;
            height: 250px;
            background: rgba(233, 30, 99, 0.08);
        }
        .floating-shapes::after {
            bottom: 20%;
            left: 3%;
            width: 200px;
            height: 200px;
            background: rgba(236, 64, 122, 0.06);
        }

        .brand-gradient {
            background: linear-gradient(135deg, #E91E63 0%, #F44336 100%);
        }
        
        .soft-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.07), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
        }
        .card-shadow {
            box-shadow: 0 4px 15px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }
        .card-shadow:hover {
            box-shadow: 0 20px 30px -5px rgba(0, 0, 0, 0.08);
            transform: translateY(-4px);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Animasi */
        .animate-fade-in-up {
             animation: fadeInUp 1s ease-out forwards;
             opacity: 0;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="antialiased font-sans text-gray-800 elegant-bg">
    <div class="relative overflow-x-hidden">
        
        {{-- Navbar --}}
        <header x-data="{ open: false, navIsScrolled: false }" @scroll.window="navIsScrolled = (window.scrollY > 50) ? true : false" :class="{ 'shadow-sm': navIsScrolled }" class="fixed top-0 left-0 right-0 z-50 glass-effect transition-shadow duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-24">
                    {{-- PENYEMPURNAAN: Logo SVG kustom + Teks dengan Font Serif --}}
                    <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="SafeTalk Homepage">
                        <svg class="h-10 w-auto" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM24 42C14.06 42 6 33.94 6 24C6 14.06 14.06 6 24 6C33.94 6 42 14.06 42 24C42 33.94 33.94 42 24 42Z" fill="#F43F5E"/>
                           <path d="M24 18C21.24 18 19 20.24 19 23V25C19 27.76 21.24 30 24 30C26.76 30 29 27.76 29 25V23C29 20.24 26.76 18 24 18ZM24 28C22.34 28 21 26.66 21 25V23C21 21.34 22.34 20 24 20C25.66 20 27 21.34 27 23V25C27 26.66 25.66 28 24 28Z" fill="#E91E63"/>
                        </svg>
                        <span class="font-serif text-2xl font-bold text-gray-900">SafeTalk</span>
                    </a>
                    <div class="hidden sm:flex items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-brand-pink transition-colors duration-300 font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-brand-pink transition-colors duration-300 font-medium">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" role="button" class="px-6 py-3 brand-gradient text-white font-semibold rounded-full hover:opacity-90 transition-all duration-300 transform hover:scale-105 soft-shadow">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="floating-shapes">
            {{-- Hero Section --}}
            <section class="min-h-screen flex items-center pt-24 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="grid md:grid-cols-2 gap-16 items-center">
                        <div class="relative z-10 text-center md:text-left">
                            <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight animate-fade-in-up" style="animation-delay: 0.2s;">
                                Memulai Perjalanan Menuju <span style="color: var(--brand-pink);" class="text-brand-pink">Ketenangan</span>.
                            </h1>
                            <p class="mt-8 text-xl text-gray-600 max-w-2xl mx-auto md:mx-0 leading-relaxed animate-fade-in-up" style="animation-delay: 0.4s;">
                                Di sini, setiap suara berharga. Temukan kekuatan dalam berbagi dan dukungan untuk bertumbuh bersama komunitas yang peduli.
                            </p>
                            <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center md:justify-start animate-fade-in-up" style="animation-delay: 0.6s;">
                                <a href="{{ route('register') }}" role="button" class="inline-flex items-center justify-center px-8 py-4 brand-gradient text-white font-semibold rounded-full shadow-lg hover:opacity-90 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                                    <span>Temukan Ruang Anda</span>
                                    <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                </a>
                            </div>
                        </div>
                        
                        <div class="relative h-96 md:h-[500px] flex items-center justify-center">
                            <img src="https://i.pinimg.com/736x/2d/3e/b6/2d3eb6190478535d2f67fb5fcf27cb58.jpg" alt="Gadis tersenyum" class="w-3/5 max-w-[280px] h-auto rounded-3xl soft-shadow transform rotate-6 transition-all duration-500 hover:scale-105 hover:rotate-3 z-10">
                             <img src="https://img.freepik.com/free-photo/indoor-shot-carefree-young-asian-woman-sits-crossed-legs-floor-keeps-arm-raised-holds-mobile-phone-listens-music-via-headphones-wears-shirt-black-trousers-isolated-red-background_273609-57647.jpg?w=740"  alt="Wanita tenang" class="w-3/5 max-w-[280px] h-auto rounded-3xl soft-shadow transform -rotate-3 transition-all duration-500 hover:scale-105 hover:-rotate-1 z-0 -ml-16 mt-16">
                        </div>
                    </div>
                </div>
            </section>

            {{-- PENYEMPURNAAN: Section Baru "Bagaimana Cara Kerjanya?" --}}
            <section id="how-it-works" class="py-24 bg-white">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                         <h2 class="font-serif text-4xl font-bold text-gray-900">3 Langkah Mudah Memulai</h2>
                         <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Kami merancang alur yang sederhana agar Anda bisa fokus pada hal terpenting: perjalanan Anda.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8 md:gap-12 relative">
                         {{-- Garis Penghubung --}}
                         <div class="hidden md:block absolute top-1/2 left-0 w-full h-px bg-gray-200" style="transform: translateY(-50%);"></div>
                         
                         <div class="relative text-center">
                              <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full brand-gradient text-white font-bold text-2xl font-serif soft-shadow mb-4">1</div>
                              <h3 class="text-xl font-bold text-gray-900 mb-2">Daftar & Buat Akun</h3>
                              <p class="text-gray-600">Buat akun aman Anda dalam beberapa menit untuk memulai.</p>
                         </div>
                         <div class="relative text-center">
                              <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full brand-gradient text-white font-bold text-2xl font-serif soft-shadow mb-4">2</div>
                              <h3 class="text-xl font-bold text-gray-900 mb-2">Bagikan Cerita Anda</h3>
                              <p class="text-gray-600">Tulis dan bagikan pengalaman Anda secara anonim di Ruang Cerita.</p>
                         </div>
                         <div class="relative text-center">
                              <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full brand-gradient text-white font-bold text-2xl font-serif soft-shadow mb-4">3</div>
                              <h3 class="text-xl font-bold text-gray-900 mb-2">Terhubung dengan Ahli</h3>
                              <p class="text-gray-600">Jadwalkan sesi konsultasi personal dengan psikolog terverifikasi kami.</p>
                         </div>
                    </div>
                </div>
            </section>

            {{-- CTA Section --}}
            <section class="py-24" style="background: var(--soft-gray);">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="font-serif text-4xl font-bold text-gray-900 mb-6">Siap Mengambil Langkah Pertama?</h2>
                    <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">Bergabunglah dengan ribuan orang yang telah menemukan kedamaian dan pertumbuhan bersama SafeTalk.</p>
                    <a href="{{ route('register') }}" role="button" class="inline-flex items-center justify-center px-10 py-4 brand-gradient text-white font-semibold rounded-full shadow-lg hover:opacity-90 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                        <span>Mulai Sekarang, Gratis</span>
                    </a>
                </div>
            </section>
            
            {{-- PENYEMPURNAAN: Footer Baru yang Lebih Profesional --}}
      <footer class="bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} SafeTalk. All Rights Reserved.
        </p>
    </div>
</footer>
        </main>
    </div>
</body>
</html>