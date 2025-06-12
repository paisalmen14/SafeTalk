<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MembershipController extends Controller
{
    public function index()
    {
        $confirmations = PaymentConfirmation::where('status', 'pending')->latest()->paginate(10);
        return view('admin.memberships.index', compact('confirmations'));
    }

     public function approve(PaymentConfirmation $confirmation)
    {
        $confirmation->status = 'approved';
        $confirmation->save();
        $user = $confirmation->user;
        $user->chosen_psychologist_id = $confirmation->psychologist_id;

        $currentExpiry = $user->membership_expires_at;
        if ($currentExpiry && $currentExpiry->isFuture()) {
            $user->membership_expires_at = $currentExpiry->addMonth();
        } else {
            
            $user->membership_expires_at = Carbon::now()->addMonth();
        }

    
        $user->save();

        return redirect()->route('admin.memberships.index')->with('success', 'Membership untuk user ' . $user->name . ' telah disetujui.');
    }

    public function reject(Request $request, PaymentConfirmation $confirmation)
    {
        $request->validate(['admin_notes' => 'required|string|max:500']);

        $confirmation->status = 'rejected';
        $confirmation->admin_notes = $request->admin_notes;
        $confirmation->save();

        return redirect()->route('admin.memberships.index')->with('success', 'Konfirmasi ditolak.');
    }
}