<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar kontak (psikolog untuk pengguna, atau pengguna untuk psikolog).
     */
    public function index()
    {
        $user = Auth::user();
        $contacts = collect();

        if ($user->role === 'pengguna' && $user->isMember()) {
            // Jika pengguna adalah member, tampilkan hanya psikolog yang telah dipilih.
            if ($user->chosen_psychologist_id) {
                $contacts = User::where('id', $user->chosen_psychologist_id)->get();
            }
        } elseif ($user->role === 'psikolog' && $user->psychologist_status === 'approved') {
            // Jika psikolog, tampilkan semua pengguna member yang telah memilihnya.
            $contacts = User::where('role', 'pengguna')
                            ->where('membership_expires_at', '>', now())
                            ->where('chosen_psychologist_id', $user->id)
                            ->latest()
                            ->get();
        }

        return view('chat.index', compact('contacts'));
    }

    /**
     * Menampilkan halaman chat dengan kontak tertentu.
     */
    public function show(User $psychologist)
    {
        $user = Auth::user();

        // Aturan Otorisasi untuk memulai chat
        if ($user->role === 'pengguna') {
            // Pengguna hanya bisa chat dengan psikolog yang dipilihnya.
            if ($user->chosen_psychologist_id !== $psychologist->id) {
                abort(403, 'Anda hanya dapat memulai chat dengan psikolog yang telah Anda pilih.');
            }
            // Pastikan target adalah psikolog yang valid.
            if ($psychologist->role !== 'psikolog' || $psychologist->psychologist_status !== 'approved') {
                abort(403, 'Anda hanya dapat memulai chat dengan psikolog terverifikasi.');
            }
        }
        
        // Psikolog hanya bisa chat dengan pengguna yang berstatus member.
        if ($user->role === 'psikolog' && !$psychologist->isMember()) {
            abort(403, 'Anda hanya dapat berinteraksi dengan pengguna yang berstatus member.');
        }

        // Mengambil riwayat pesan antara dua pengguna.
        $messages = Chat::where(function ($q) use ($user, $psychologist) {
            $q->where('sender_id', $user->id)->where('receiver_id', $psychologist->id);
        })->orWhere(function ($q) use ($user, $psychologist) {
            $q->where('sender_id', $psychologist->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // Tandai pesan yang diterima sebagai sudah dibaca.
        Chat::where('sender_id', $psychologist->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.show', ['contact' => $psychologist, 'messages' => $messages]);
    }

    /**
     * Menyimpan pesan baru.
     */
    public function store(Request $request, User $psychologist)
    {
        $request->validate(['message' => 'required|string|max:2000']);
        
        $user = Auth::user();
        
        // Aturan Otorisasi untuk mengirim pesan
        if ($user->role === 'pengguna') {
            if ($user->chosen_psychologist_id !== $psychologist->id) {
                return back()->with('error', 'Tidak dapat mengirim pesan ke psikolog ini.');
            }
        }

        if (($user->role === 'pengguna' && ($psychologist->role !== 'psikolog' || $psychologist->psychologist_status !== 'approved')) ||
            ($user->role === 'psikolog' && !$psychologist->isMember())) {
            return back()->with('error', 'Tidak dapat mengirim pesan ke pengguna ini.');
        }

        // Buat pesan baru
        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $psychologist->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $psychologist);
    }
}
