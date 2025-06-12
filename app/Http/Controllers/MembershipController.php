<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentConfirmation;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon; // <-- Tambahkan ini untuk menggunakan Carbon

class MembershipController extends Controller
{
    /**
     * Menampilkan halaman formulir pendaftaran keanggotaan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $psychologists = User::where('role', 'psikolog')
                             ->where('psychologist_status', 'approved')
                             ->orderBy('name')
                             ->get();

        return view('membership.index', compact('psychologists')); // Kirim data ke view 
    }

    /**
     * Menyimpan konfirmasi pembayaran baru dari pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:100000',
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'psychologist_id' => 'required|exists:users,id', // Validasi psikolog yang dipilih
        ]);

        $path = $request->file('proof')->store('proofs', 'public');

        // Pastikan psikolog yang dipilih memang seorang psikolog
        $psychologist = User::find($request->psychologist_id);
        if (!$psychologist || $psychologist->role !== 'psikolog' || $psychologist->psychologist_status !== 'approved') {
            return back()->with('error', 'Psikolog yang dipilih tidak valid.');
        }

        PaymentConfirmation::create([
            'user_id' => auth()->id(),
            'psychologist_id' => $request->psychologist_id, // Simpan ID psikolog
            'transaction_id' => 'TRX-' . time() . '-' . Str::upper(Str::random(4)),
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'proof_path' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', 'Konfirmasi pembayaran telah dikirim. Admin akan segera memverifikasinya.');
    }

    /**
     * Menyetujui konfirmasi pembayaran (HANYA UNTUK ADMIN).
     *
     * @param  \App\Models\PaymentConfirmation  $confirmation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(PaymentConfirmation $confirmation)
    {
        // Ubah status konfirmasi menjadi 'approved'
        $confirmation->status = 'approved';
        $confirmation->save();

        // Ambil data pengguna yang bersangkutan
        $user = $confirmation->user;

        // Set psikolog yang dipilih ke profil pengguna
        if ($confirmation->psychologist_id) {
            $user->chosen_psychologist_id = $confirmation->psychologist_id;
        }

        // Jika sudah jadi member, perpanjang. Jika belum, set baru.
        $currentExpiry = $user->membership_expires_at;

        if ($currentExpiry && Carbon::parse($currentExpiry)->isFuture()) {
            $user->membership_expires_at = Carbon::parse($currentExpiry)->addMonth();
        } else {
            $user->membership_expires_at = Carbon::now()->addMonth();
        }

        // Simpan semua perubahan (expiry & chosen_psychologist_id)
        $user->save();

        // Redirect admin dengan pesan sukses
        // Anda mungkin perlu membuat route 'admin.memberships.index'
        return redirect()->route('admin.memberships.index')->with('success', 'Membership disetujui.'); 
    }
}
