<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role === 'admin' ? 'Moderasi Konten' : 'Ruang Cerita' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter & Search Bar --}}
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="search" class="sr-only">Cari Cerita</label>
                            <input type="text" name="search" id="search" placeholder="Cari cerita berdasarkan kata kunci..."
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ request('search') }}">
                        </form>
                    </div>
                    <div class="flex items-center justify-start md:justify-end space-x-4 text-sm font-medium">
                        <span class="text-gray-500">Urutkan:</span>
                        <a href="{{ route('dashboard', ['filter' => 'newest', 'search' => request('search')]) }}"
                        class="{{ request('filter', 'newest') == 'newest' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                        Terbaru
                        </a>
                        <a href="{{ route('dashboard', ['filter' => 'top', 'search' => request('search')]) }}"
                        class="{{ request('filter') == 'top' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                        Paling Ramai
                        </a>
                        <a href="{{ route('dashboard', ['filter' => 'popular', 'search' => request('search')]) }}"
                        class="{{ request('filter') == 'popular' ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                        Populer
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tombol "Tulis Cerita Baru" hanya muncul jika BUKAN admin --}}
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('stories.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                            + Tulis Cerita Baru
                        </a>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($stories as $story)
                            <div class="p-6 bg-white border rounded-lg shadow-sm">
                                
                                <div class="flex justify-between items-start">
                                    <div class="font-medium">
                                        @if ($story->is_anonymous)
                                            <span class="text-gray-600 font-bold">Anonim</span>
                                        @else
                                            <a href="{{ route('profile.show', $story->user) }}" class="text-gray-900 font-bold hover:underline">
                                                {{ $story->user->name }}
                                            </a>
                                            <span class="text-gray-500 font-normal text-sm block">{{'@'}}{{ $story->user->username }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 flex-shrink-0">
                                        {{ $story->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <p class="mt-4 text-gray-800 whitespace-pre-wrap">{{ $story->content }}</p>

                                {{-- BAGIAN AKSI (VOTE, EDIT, HAPUS, KOMENTAR) --}}
                                <div class="mt-4 flex items-center justify-between border-t pt-4">
                                    
                                    {{-- Fitur vote hanya muncul jika BUKAN admin --}}
                                    @if(Auth::user()->role !== 'admin')
                                        <div class="flex items-center space-x-4 text-gray-500"
                                            x-data="{
                                                userVote: {{ $story->userVote() ?? 0 }},
                                                upvotes: {{ $story->upvotes_count ?? 0 }},
                                                downvotes: {{ $story->downvotes_count ?? 0 }},
                                                vote: function(type) {
                                                    fetch('{{ route('stories.vote', $story) }}', {
                                                        method: 'POST',
                                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                        body: JSON.stringify({ vote: type })
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        this.upvotes = data.upvotes_count;
                                                        this.downvotes = data.downvotes_count;
                                                        if (type === 'up') {
                                                            this.userVote = this.userVote === 1 ? 0 : 1;
                                                        } else if (type === 'down') {
                                                            this.userVote = this.userVote === -1 ? 0 : -1;
                                                        }
                                                    });
                                                }
                                            }">
                                            
                                            <div class="flex items-center space-x-1.5">
                                                <button @click="vote('up')" class="p-1.5 rounded-full hover:bg-blue-50" :class="{ 'text-blue-600 bg-blue-50': userVote === 1, 'text-gray-500 hover:text-blue-600': userVote !== 1 }">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="userVote === 1 ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 14-6 6-6-6a5 5 0 0 1 0-7 5 5 0 0 1 7 0 5 5 0 0 1 7 0 5 5 0 0 1 0 7z"/></svg>
                                                </button>
                                                <span class="text-sm font-semibold" x-text="upvotes"></span>
                                            </div>

                                            <div class="flex items-center space-x-1.5">
                                                <button @click="vote('down')" class="p-1.5 rounded-full hover:bg-orange-50" :class="{ 'text-orange-600 bg-orange-50': userVote === -1, 'text-gray-500 hover:text-orange-600': userVote !== -1 }">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="userVote === -1 ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5"/><path d="m12 13-1-1 2-2-3-3 2-2"/></svg>
                                                </button>
                                                <span class="text-sm font-semibold" x-text="downvotes"></span>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Beri placeholder kosong agar layout tidak berantakan --}}
                                        <div>&nbsp;</div>
                                    @endif

                                    {{-- SISI KANAN: AKSI LAINNYA --}}
                                    <div class="flex items-center space-x-4">
                                        @can('update-story', $story)
                                            <a href="{{ route('stories.edit', $story) }}" class="text-sm font-medium text-yellow-600 hover:text-yellow-800">Edit</a>
                                        @endcan
                                        @can('delete-story', $story)
                                            <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                            </form>
                                        @endcan
                                        
                                        <a href="{{ route('stories.show', $story) }}" class="flex items-center space-x-2 text-gray-500 hover:text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            <span>{{ $story->comments_count }} Komentar</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                                <p>Tidak ada cerita yang cocok dengan kriteria Anda.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $stories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>