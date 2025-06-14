<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ProfileController extends Controller
{
    public function edit()
    {
        $psychologist = Auth::user();
        $profile = $psychologist->psychologistProfile()->firstOrCreate(['user_id' => $psychologist->id]);
        return view('psychologist.profile.edit', compact('psychologist', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'price_per_hour' => 'required|numeric|min:0',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk gambar
        ]);

        $psychologist = Auth::user();
        $profile = $psychologist->psychologistProfile;

        $dataToUpdate = [
            'price_per_hour' => $request->price_per_hour,
        ];

        // Cek jika ada file gambar baru yang di-upload
        if ($request->hasFile('profile_image')) {
            // Hapus gambar lama jika ada
            if ($profile->profile_image_path) {
                Storage::disk('public')->delete($profile->profile_image_path);
            }
            // Simpan gambar baru dan dapatkan path-nya
            $path = $request->file('profile_image')->store('profile_pictures', 'public');
            $dataToUpdate['profile_image_path'] = $path;
        }

        $profile->update($dataToUpdate);

        return redirect()->route('psychologist.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}