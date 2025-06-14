<?php
namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceController extends Controller
{
    public function edit()
    {
        $psychologist = Auth::user();
        $profile = $psychologist->psychologistProfile()->firstOrCreate(['user_id' => $psychologist->id]);
        return view('psychologist.price.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate(['price_per_hour' => 'required|numeric|min:0']);
        $psychologist = Auth::user();
        $psychologist->psychologistProfile->update(['price_per_hour' => $request->price_per_hour]);
        return back()->with('success', 'Harga berhasil diperbarui.');
    }
}