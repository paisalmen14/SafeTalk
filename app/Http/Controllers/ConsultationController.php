<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ConsultationController extends Controller
{
    // Menampilkan daftar psikolog yang tersedia
    public function index()
    {
        $psychologists = User::where('role', 'psikolog')
            ->where('psychologist_status', 'approved')
            ->with('psychologistProfile')
            ->paginate(10);
        return view('consultations.index', compact('psychologists'));
    }

    // Menampilkan detail satu psikolog dan jadwalnya
    public function show(User $psychologist)
    {
        $psychologist->load('psychologistProfile', 'availabilities');
        $availableSlots = $psychologist->availabilities()
            ->where('is_booked', false)
            ->where('start_time', '>', now())
            ->get();
            
        return view('consultations.show', compact('psychologist', 'availableSlots'));
    }

    // Proses membuat reservasi
    public function store(Request $request)
    {
        $request->validate([
            'psychologist_id' => 'required|exists:users,id',
            'requested_start_time' => 'required|date',
            'duration_minutes' => 'required|integer|in:30,60,90', // Contoh durasi
        ]);

        $psychologist = User::with('psychologistProfile')->find($request->psychologist_id);
        $user = Auth::user();

        // Hitung biaya
        $pricePerHour = $psychologist->psychologistProfile->price_per_hour;
        $psychologistPrice = ($pricePerHour / 60) * $request->duration_minutes;
        $adminFee = $psychologistPrice * 0.05; // Fee 5%
        $totalPayment = $psychologistPrice + $adminFee;

        // Buat konsultasi
        $consultation = Consultation::create([
            'user_id' => $user->id,
            'psychologist_id' => $psychologist->id,
            'requested_start_time' => $request->requested_start_time,
            'duration_minutes' => $request->duration_minutes,
            'psychologist_price' => $psychologistPrice,
            'admin_fee' => $adminFee,
            'total_payment' => $totalPayment,
            'status' => 'pending_payment',
            'expires_at' => now()->addHour(),
        ]);
        
        // Redirect ke halaman pembayaran
        return redirect()->route('consultations.payment.create', $consultation);
    }

    // Menampilkan riwayat konsultasi user
   public function history()
    {
        $user = auth()->user();
        $consultations = collect();

        if ($user->role === 'pengguna') {
            // Ambil riwayat untuk pasien
            // PERBAIKAN DI SINI: Gunakan relasi consultationsAsUser()
            $consultations = $user->consultationsAsUser()->with('psychologist')->latest()->paginate(10);
        } elseif ($user->role === 'psikolog') {
            // Ambil riwayat untuk psikolog
            // PERBAIKAN DI SINI: Gunakan relasi consultationsAsPsychologist()
            $consultations = $user->consultationsAsPsychologist()->with('user')->latest()->paginate(10);
        }

        return view('consultations.history', compact('consultations'));
    }
}
