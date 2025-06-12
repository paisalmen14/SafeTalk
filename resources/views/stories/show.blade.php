<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Cerita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div class="font-bold text-xl">
                            @if ($story->is_anonymous)
                                <span class="text-gray-600">Anonim</span>
                            @else
                                {{ $story->user->name }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $story->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $story->content }}</p>
                </div>
            </div>

            {{-- Form Komentar hanya akan muncul jika pengguna BUKAN admin --}}
            @if(Auth::user()->role !== 'admin')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg mb-4">Tinggalkan Komentar</h3>
                        <form action="{{ route('comments.store', $story) }}" method="POST">
                            @csrf
                            <textarea name="content" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tulis komentarmu di sini..."></textarea>
                            @error('content')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">Komentar</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        @forelse ($story->comments->whereNull('parent_id') as $comment)
                            @include('partials._comment', ['comment' => $comment, 'story' => $story])
                        @empty
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama!</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>