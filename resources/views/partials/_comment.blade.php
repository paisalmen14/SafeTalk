<div class="border-b pb-4 @if($comment->parent_id) ml-6 md:ml-12 border-l pl-4 @endif">
    {{-- Tampilan Komentar --}}
    <div class="flex items-center mb-1">
        
        {{-- Cek apakah cerita ini anonim DAN commenter adalah penulis cerita --}}
        @if ($story->is_anonymous && $comment->user_id == $story->user_id)
            <p class="font-semibold text-blue-600">Penulis Anonim</p>
        @else
            <p class="font-semibold">{{ $comment->user->name }}</p>
        @endif

        <p class="text-xs text-gray-500 ml-2">- {{ $comment->created_at->diffForHumans() }}</p>
    </div>
    <p class="text-gray-700">{{ $comment->content }}</p>

    {{-- Tombol & Form Balas (menggunakan Alpine.js untuk show/hide) --}}
    <div class="mt-2 flex items-center space-x-4">
        
        {{-- Tombol "Balas" dan form-nya hanya muncul jika pengguna BUKAN admin --}}
        @if(Auth::user()->role !== 'admin')
            <div x-data="{ open: false }" class="mt-2">
                <button @click="open = !open" class="text-sm text-blue-500 hover:underline">Balas</button>

                <div x-show="open" x-cloak class="mt-2" style="display: none;">
                    <form action="{{ route('comments.store', $story) }}" method="POST">
                        @csrf
                        <textarea name="content" rows="2" class="mt-1 block w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tulis balasan..."></textarea>
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="flex justify-end mt-2">
                            <button type="button" @click="open = false" class="text-sm text-gray-600 mr-2">Batal</button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Tombol Hapus akan muncul untuk pemilik komentar ATAU admin --}}
        @can('delete-comment', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:underline">Hapus</button>
            </form>
        @endcan
    </div>
</div>

{{-- Panggil Diri Sendiri Untuk Menampilkan Balasan (Recursion) --}}
@if ($comment->replies->isNotEmpty())
    <div class="space-y-4 mt-4">
        @foreach ($comment->replies as $reply)
            {{-- Pastikan variabel $story diteruskan juga ke balasan --}}
            @include('partials._comment', ['comment' => $reply, 'story' => $story])
        @endforeach
    </div>
@endif