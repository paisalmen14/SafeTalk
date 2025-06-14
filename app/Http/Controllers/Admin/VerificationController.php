<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Notifications\ConsultationVerifiedUser; // Buat notifikasi ini
use App\Notifications\ConsultationVerifiedPsychologist; // Buat notifikasi ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class VerificationController extends Controller
{
    // Menampilkan daftar konsultasi yang butuh verifikasi
    public function index()
    {
        $consultations = Consultation::where('status', 'pending_verification')
            ->with('user', 'psychologist', 'paymentConfirmation')
            ->latest()
            ->paginate(15);
        
        return view('admin.verifications.index', compact('consultations'));
    }

    // Menyetujui pembayaran
    public function approve(Consultation $consultation)
{
    $consultation->update(['status' => 'confirmed']);
    $consultation->paymentConfirmation()->update(['status' => 'approved']); // <-- Ganti menjadi 'approved'

    // Kirim notifikasi
    $consultation->user->notify(new ConsultationVerifiedUser($consultation));
    $consultation->psychologist->notify(new ConsultationVerifiedPsychologist($consultation));

    return back()->with('success', 'Pembayaran berhasil diverifikasi.');
}
    
    // Menolak pembayaran
    public function reject(Request $request, Consultation $consultation)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $consultation->update(['status' => 'payment_rejected']);
        $consultation->paymentConfirmation()->update([
            'status' => 'rejected',
            'admin_notes' => $request->rejection_reason,
        ]);
        
        // Kirim notifikasi ke user bahwa pembayaran ditolak beserta alasannya
        // $consultation->user->notify(new PaymentRejectedNotification($consultation, $request->rejection_reason));

        return back()->with('success', 'Pembayaran telah ditolak.');
    }
}