<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PsychologistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PsychologistRegisterController extends Controller
{
    // Menampilkan form pendaftaran
    public function create()
    {
        return view('auth.register-psychologist');
    }

 

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ktp_number' => ['required', 'string', 'digits:16'], // Diubah ke nomor KTP
            'university' => ['required', 'string', 'max:255'],
            'graduation_year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:'.(date('Y'))],
            'certificate' => ['required', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'ktp_image' => ['required', 'file', 'mimes:jpg,png,jpeg', 'max:2048'], // Validasi untuk gambar KTP
        ]);

        // 1. Simpan file sertifikat dan KTP
        $certificatePath = $request->file('certificate')->store('certificates', 'public');
        $ktpPath = $request->file('ktp_image')->store('ktp_images', 'public');

        // 2. Buat user baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'psikolog',
            'psychologist_status' => 'pending',
        ]);

        // 3. Buat profil psikolog yang terhubung dengan user
        $user->psychologistProfile()->create([
            'ktp_number' => $request->ktp_number, // Diubah ke ktp_number
            'university' => $request->university,
            'graduation_year' => $request->graduation_year,
            'certificate_path' => $certificatePath,
            'ktp_path' => $ktpPath, // Simpan path KTP
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda akan segera diverifikasi oleh Admin sebelum dapat digunakan.');
    }
}