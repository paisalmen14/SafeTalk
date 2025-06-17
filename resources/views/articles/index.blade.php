{{-- resources/views/articles/index.blade.php (Versi Elegan Baru) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-gray-900">
            {{ __('Artikel Kesehatan Mental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($articles as $article)
                    {{-- Menggunakan style kartu yang konsisten --}}
                    <div class="bg-white overflow-hidden rounded-2xl card-shadow border border-gray-100 flex flex-col group">
                        <a href="{{ route('articles.show', $article) }}">
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 leading-tight">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-brand-pink transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <div class="text-sm text-gray-500 mb-4">
                                Diposting {{ $article->created_at->diffForHumans() }}
                            </div>
                            <p class="text-gray-700 text-sm line-clamp-3 flex-grow">
                                {{ Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('articles.show', $article) }}" class="font-semibold text-brand-pink hover:underline">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 rounded-2xl card-shadow border border-gray-100 text-center">
                        <p class="text-gray-500">Belum ada artikel yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>