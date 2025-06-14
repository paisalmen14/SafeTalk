<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user kecuali admin yang sedang login, urutkan dari yang terbaru
        $users = User::where('id', '!=', Auth::id())
                     ->latest()
                     ->paginate(20);
                     
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Tambahan keamanan: pastikan admin tidak bisa menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Tambahan keamanan: jangan hapus admin lain
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus sesama admin.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}