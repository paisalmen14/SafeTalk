<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ Auth::user()->role === 'admin' ? 'Moderasi Konten' : 'Ruang Cerita' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter & Search Bar diubah ke slate-800 --}}
            <div class="bg-slate-800 p-4 rounded-lg shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="search" class="sr-only">Cari Cerita</label>
                            <input type="text" name="search" id="search" placeholder="Cari cerita berdasarkan kata kunci..."
                                class="w-full bg-slate-900 border-slate-600 rounded-md shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-500 focus:ring-opacity-50"
                                value="{{ request('search') }}">
                        </form>
                    </div>
                    {{-- Warna link filter disesuaikan --}}
                    <div class="flex items-center justify-start md:justify-end space-x-4 text-sm font-medium">
                        <span class="text-slate-400">Urutkan:</span>
                        <a href="{{ route('dashboard', ['filter' => 'newest', 'search' => request('search')]) }}"
                        class="{{ request('filter', 'newest') == 'newest' ? 'text-cyan-400 font-bold' : 'text-slate-400 hover:text-cyan-400' }}">
                        Terbaru
                        </a>
                        <a href="{{ route('dashboard', ['filter' => 'top', 'search' => request('search')]) }}"
                        class="{{ request('filter') == 'top' ? 'text-cyan-400 font-bold' : 'text-slate-400 hover:text-cyan-400' }}">
                        Paling Ramai
                        </a>
                        <a href="{{ route('dashboard', ['filter' => 'popular', 'search' => request('search')]) }}"
                        class="{{ request('filter') == 'popular' ? 'text-cyan-400 font-bold' : 'text-slate-400 hover:text-cyan-400' }}">
                        Populer
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card utama diubah ke slate-800 --}}
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-100">
                    
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('stories.create') }}" class="inline-block bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-2 px-4 rounded mb-4">
                            + Tulis Cerita Baru
                        </a>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-500/10 border border-green-400 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-500/10 border border-red-400 text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @forelse ($stories as $story)
                            {{-- Card per cerita diubah ke slate-800 dengan border slate-700 --}}
                            <div class="p-6 bg-slate-800 border border-slate-700 rounded-lg shadow-sm">
                                
                                <div class="flex justify-between items-start">
                                    <div class="font-medium">
                                        @if ($story->is_anonymous)
                                            <span class="text-slate-300 font-bold">Anonim</span>
                                        @else
                                            <a href="{{ route('profile.show', $story->user) }}" class="text-slate-100 font-bold hover:underline">
                                                {{ $story->user->name }}
                                            </a>
                                            <span class="text-slate-400 font-normal text-sm block">{{'@'}}{{ $story->user->username }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-400 flex-shrink-0">
                                        {{ $story->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <p class="mt-4 text-slate-300 whitespace-pre-wrap">{{ $story->content }}</p>

                                {{-- Aksi dengan warna yang disesuaikan --}}
                                <div class="mt-4 flex items-center justify-between border-t border-slate-700 pt-4">
                                    
                                    @if(Auth::user()->role !== 'admin')
                                        <div class="flex items-center space-x-4 text-slate-400"
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
                                                <button @click="vote('up')" class="p-1.5 rounded-full hover:bg-cyan-500/10" :class="{ 'text-cyan-400 bg-cyan-500/10': userVote === 1, 'text-slate-400 hover:text-cyan-400': userVote !== 1 }">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="userVote === 1 ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                                </button>
                                                <span class="text-sm font-semibold" x-text="upvotes"></span>
                                            </div>

                                            <div class="flex items-center space-x-1.5">
                                                <button @click="vote('down')" class="p-1.5 rounded-full hover:bg-orange-500/10" :class="{ 'text-orange-400 bg-orange-500/10': userVote === -1, 'text-slate-400 hover:text-orange-400': userVote !== -1 }">
                                                   <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="userVote === -1 ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><<path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/></svg>
                                                </button>
                                                <span class="text-sm font-semibold" x-text="downvotes"></span>
                                            </div>
                                        </div>
                                    @else
                                        <div>&nbsp;</div>
                                    @endif

                                    <div class="flex items-center space-x-4">
                                        @can('update-story', $story)
                                            <a href="{{ route('stories.edit', $story) }}" class="text-sm font-medium text-yellow-500 hover:text-yellow-400">Edit</a>
                                        @endcan
                                        @can('delete-story', $story)
                                            <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-400">Hapus</button>
                                            </form>
                                        @endcan
                                        
                                        <a href="{{ route('stories.show', $story) }}" class="flex items-center space-x-2 text-slate-400 hover:text-cyan-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            <span>{{ $story->comments_count }} Komentar</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-slate-800 border border-slate-700 p-6 rounded-lg shadow-sm text-center">
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