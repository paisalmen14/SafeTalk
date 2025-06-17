{{-- resources/views/dashboard.blade.php (Versi Elegan Baru) --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-serif font-bold text-3xl text-gray-900">
                {{ __('Ruang Cerita') }}
            </h2>
            <a href="{{ route('stories.create') }}" class="inline-block px-6 py-2 brand-gradient text-white font-semibold rounded-full shadow-sm hover:opacity-90 transition-all">
                + Tulis Cerita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search & Filter Bar --}}
            <div class="mb-8 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row gap-4 justify-between">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex-grow">
                        <input type="text" name="search" placeholder="Cari cerita..." class="w-full md:w-2/3 border-gray-300 rounded-full focus:ring-brand-pink focus:border-brand-pink" value="{{ request('search') }}">
                    </form>
                    <div class="flex items-center justify-end space-x-4 text-sm font-medium text-gray-600">
                        <span>Urutkan:</span>
                        <a href="{{ route('dashboard', ['filter' => 'newest']) }}" class="{{ request('filter', 'newest') == 'newest' ? 'text-brand-pink font-bold' : 'hover:text-brand-pink' }}">Terbaru</a>
                        <a href="{{ route('dashboard', ['filter' => 'top']) }}" class="{{ request('filter') == 'top' ? 'text-brand-pink font-bold' : 'hover:text-brand-pink' }}">Paling Ramai</a>
                    </div>
                </div>
            </div>

            {{-- Daftar Cerita --}}
            <div class="space-y-6">
                @forelse ($stories as $story)
                    <div class="bg-white p-6 rounded-2xl card-shadow border border-gray-100">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                                    {{ $story->is_anonymous ? 'A' : strtoupper(substr($story->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $story->is_anonymous ? 'Anonim' : $story->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $story->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            {{-- Dropdown Aksi (jika ada) --}}
                        </div>
                        <p class="mt-4 text-gray-800 leading-relaxed">{{ $story->content }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                             <div class="flex items-center space-x-4 text-gray-500">
                                {{-- Tombol Upvote & Downvote --}}
                            </div>
                            <a href="{{ route('stories.show', $story) }}" class="text-sm font-medium text-gray-600 hover:text-brand-pink">
                                {{ $story->comments_count }} Komentar &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-2xl card-shadow border border-gray-100 text-center">
                        <p class="text-gray-500">Belum ada cerita yang dibagikan.</p>
                    </div>
                @endforelse
            </div>

             <div class="mt-8">
                {{ $stories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>