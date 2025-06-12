{{-- resources/views/articles/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-auto object-cover">
                <div class="p-6 md:p-8 text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">{{ $article->title }}</h1>
                    <p class="text-sm text-gray-500 mb-6">
                        Oleh: {{ $article->user->name }} &bull; Diposting pada {{ $article->created_at->format('d F Y') }}
                    </p>

                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($article->content)) !!}
                    </div>

                     <div class="mt-8 border-t pt-4">
                        <a href="{{ route('articles.index') }}" class="text-blue-500 hover:underline">
                            &larr; Kembali ke semua artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>