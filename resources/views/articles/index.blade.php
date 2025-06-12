{{-- resources/views/articles/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Artikel Kesehatan Mental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($articles as $article)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('articles.show', $article) }}">
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <div class="text-sm text-gray-500 mb-4">
                                Diposting {{ $article->created_at->diffForHumans() }}
                            </div>
                            <p class="text-gray-700 text-sm line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('articles.show', $article) }}" class="text-blue-500 hover:underline font-semibold">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded-lg shadow-sm text-center">
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