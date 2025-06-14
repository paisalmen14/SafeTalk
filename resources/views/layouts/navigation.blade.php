<nav x-data="{ open: false }" class="bg-slate-800 border-b border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto fill-current text-slate-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Ruang Cerita') }}
                    </x-nav-link>
                    <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index') || request()->routeIs('articles.show')">
                        {{ __('Artikel') }}
                    </x-nav-link>
                    <x-nav-link :href="route('chatbot.index')" :active="request()->routeIs('chatbot.index')">
                        {{ __('Konsultasi AI') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'psikolog')
                        <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')">
                            {{ __('Ruang Chat') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'pengguna')
                        @if($hasActiveConsultation)
                            <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')">
                                <span class="text-green-400 font-bold">{{ __('Ruang Chat') }}</span>
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('consultations.index')" :active="request()->routeIs('consultations.*')">
                                <span class="text-cyan-400 font-bold">{{ __('Konsultasi Profesional') }}</span>
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-notification-dropdown />
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-400 bg-slate-800 hover:text-slate-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->role === 'admin')
                            <div class="block px-4 py-2 text-xs text-slate-400">
                                {{ __('Menu Admin') }}
                            </div>
                            <x-dropdown-link :href="route('admin.users.index')">
                                {{ __('Kelola Pengguna') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.articles.index')">
                                {{ __('Manajemen Artikel') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.consultation.verifications.index')">
                                {{ __('Verifikasi Konsultasi') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.psychologists.index')">
                                {{ __('Verifikasi Psikolog') }}
                            </x-dropdown-link>
                            <div class="border-t border-slate-600"></div>
                        @endif

                        @if(Auth::user()->role === 'psikolog')
                            <div class="block px-4 py-2 text-xs text-slate-400">
                                {{ __('Menu Psikolog') }}
                            </div>
                            <x-dropdown-link :href="route('psychologist.price.edit')">
                                {{ __('Pengaturan Harga') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('psychologist.profile_picture.edit')">
                                {{ __('Ganti Foto Profil') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('psychologist.availability.index')">
                                {{ __('Kelola Jadwal') }}
                            </x-dropdown-link>
                             <div class="border-t border-slate-600"></div>
                        @endif

                        @if(Auth::user()->role !== 'admin')
                            <x-dropdown-link :href="route('consultations.history')">
                                {{ __('Riwayat Konsultasi') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.show', auth()->user())">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Edit Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-300 hover:bg-slate-700 focus:outline-none focus:bg-slate-700 focus:text-slate-300 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Ruang Cerita') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.index') || request()->routeIs('articles.show')">
                {{ __('Artikel') }}
            </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('chatbot.index')" :active="request()->routeIs('chatbot.index')">
                {{ __('Konsultasi AI') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'psikolog')
                 <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')">
                    {{ __('Ruang Chat') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'pengguna')
                @if($hasActiveConsultation)
                    <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')">
                        <span class="text-green-400 font-bold">{{ __('Ruang Chat') }}</span>
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('consultations.index')" :active="request()->routeIs('consultations.*')">
                        <span class="text-cyan-400 font-bold">{{ __('Konsultasi Profesional') }}</span>
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-600">
            <div class="px-4">
                <div class="font-medium text-base text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->role === 'admin')
                    <div class="block px-4 py-2 text-xs text-slate-400">
                        {{ __('Menu Admin') }}
                    </div>
                    <x-responsive-nav-link :href="route('admin.users.index')">
                        {{ __('Kelola Pengguna') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.articles.index')">
                        {{ __('Manajemen Artikel') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.consultation.verifications.index')">
                        {{ __('Verifikasi Konsultasi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.psychologists.index')">
                        {{ __('Verifikasi Psikolog') }}
                    </x-responsive-nav-link>
                     <div class="border-t border-slate-600 my-1"></div>
                @endif
                
                @if(Auth::user()->role === 'psikolog')
                    <div class="block px-4 py-2 text-xs text-slate-400">
                        {{ __('Menu Psikolog') }}
                    </div>
                    <x-responsive-nav-link :href="route('psychologist.price.edit')">
                        {{ __('Pengaturan Harga') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('psychologist.profile_picture.edit')">
                        {{ __('Ganti Foto Profil') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('psychologist.availability.index')">
                        {{ __('Kelola Jadwal') }}
                    </x-responsive-nav-link>
                     <div class="border-t border-slate-600 my-1"></div>
                @endif
                
                @if(Auth::user()->role !== 'admin')
                    <x-responsive-nav-link :href="route('consultations.history')">
                        {{ __('Riwayat Konsultasi') }}
                    </x-responsive-nav-link>
                @endif
                
                <x-responsive-nav-link :href="route('profile.show', auth()->user())">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Edit Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>