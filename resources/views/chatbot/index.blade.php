<x-app-layout>
    <x-slot name="header">
        {{-- Mengubah header agar tombol Hapus History bisa masuk --}}
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ruang Konsultasi AI - SafeTalk') }}
            </h2>
            {{-- Tombol untuk menghapus history --}}
            <div x-data="chatBot" x-init="init()">
                <button @click="confirmClearHistory()" class="text-sm font-medium text-gray-600 hover:text-red-700 focus:outline-none">
                    Hapus History
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800">
                        <p class="font-bold">Penting!</p>
                        <p class="text-sm">Anda sedang berbicara dengan AI. Interaksi ini bukan pengganti konsultasi profesional dan riwayat percakapan disimpan di peramban Anda. Jika Anda berada dalam situasi krisis, segera hubungi tenaga kesehatan mental.</p>
                    </div>

                    {{-- Komponen Chat dengan Alpine.js yang sudah di-update --}}
                    <div x-data="chatBot" x-init="init()">
                        <div class="h-96 overflow-y-auto border rounded-lg p-4 mb-4 space-y-4" x-ref="chatbox">
                            <template x-for="message in messages" :key="message.id">
                                <div class="flex" :class="message.role === 'user' ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-xs md:max-w-md rounded-lg p-3" :class="message.role === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'">
                                        <p class="whitespace-pre-wrap" x-html="message.text"></p>
                                    </div>
                                </div>
                            </template>
                            <div x-show="loading" class="flex justify-start">
                                <div class="max-w-xs md:max-w-md rounded-lg p-3 bg-gray-200 text-gray-800">
                                    <p><em>Mengetik...</em></p>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="sendMessage">
                            <div class="flex space-x-2">
                                <input type="text" x-model="userInput" placeholder="Ketik pesan Anda..." class="flex-grow border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :disabled="loading" autocomplete="off">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50" :disabled="loading">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    function chatBot() {
        return {
            userInput: '',
            loading: false,
            messageId: 0,
            chatHistoryKey: `safetalk_chat_history_{{ auth()->id() }}`, // Kunci unik untuk setiap pengguna
            initialMessage: { id: 1, role: 'bot', text: 'Halo! Aku SafeTalk, teman curhat virtualmu. Apa yang sedang kamu rasakan saat ini?' },
            messages: [],

            // Fungsi yang dijalankan saat komponen dimuat
            init() {
                const savedHistory = localStorage.getItem(this.chatHistoryKey);
                this.messages = savedHistory ? JSON.parse(savedHistory) : [this.initialMessage];
                this.messageId = this.messages.length > 0 ? Math.max(...this.messages.map(m => m.id)) : 1;
                this.scrollToBottom();
            },

            // Fungsi untuk menyimpan history ke localStorage
            saveHistory() {
                localStorage.setItem(this.chatHistoryKey, JSON.stringify(this.messages));
            },

            // Fungsi untuk menghapus history
            confirmClearHistory() {
                if (confirm('Apakah Anda yakin ingin menghapus seluruh riwayat percakapan di peramban ini?')) {
                    // Hapus data dari localStorage
                    localStorage.removeItem(this.chatHistoryKey);
                    
                    // Me-refresh halaman
                    location.reload();
                }
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    this.$refs.chatbox.scrollTop = this.$refs.chatbox.scrollHeight;
                });
            },

            sendMessage() {
                if (this.userInput.trim() === '') return;

                this.messageId++;
                this.messages.push({ id: this.messageId, role: 'user', text: this.userInput });
                this.saveHistory();
                this.scrollToBottom();

                const userMessageToSend = this.userInput;
                this.userInput = '';
                this.loading = true;

                // Siapkan history untuk dikirim ke API
                const historyForApi = this.messages.slice(1, -1).map(msg => ({
                    role: msg.role === 'user' ? 'user' : 'model',
                    text: msg.text
                }));

                fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        message: userMessageToSend,
                        history: historyForApi
                    })
                })
                .then(response => {
                    if (!response.ok) { throw new Error('Network response was not ok'); }
                    return response.json();
                })
                .then(data => {
                    this.loading = false;
                    if(data.reply) {
                        this.messageId++;
                        this.messages.push({ id: this.messageId, role: 'bot', text: data.reply });
                        this.saveHistory();
                        this.scrollToBottom();
                    } else if (data.error) {
                        this.handleError(data.error);
                    }
                })
                .catch(error => {
                    this.handleError('Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
                    console.error('Error:', error);
                });
            },
            
            handleError(errorMessage) {
                this.loading = false;
                this.messageId++;
                this.messages.push({ id: this.messageId, role: 'bot', text: errorMessage });
                this.saveHistory();
                this.scrollToBottom();
            }
        }
    }
</script>
</x-app-layout>