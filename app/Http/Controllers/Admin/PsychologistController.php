<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
   public function index()
   {
        $psychologists = User::with('psychologistProfile') // Tambahkan ini
            ->where('role', 'psikolog')
            ->where('psychologist_status', 'pending')
            ->latest()->paginate(10);

        return view('admin.psychologists.index', compact('psychologists'));
    }

    public function approve(User $psychologist)
    {
        if ($psychologist->role === 'psikolog') {
            $psychologist->psychologist_status = 'approved';
            $psychologist->save();
            return redirect()->route('admin.psychologists.index')->with('success', 'Psikolog telah disetujui.');
        }
        return redirect()->route('admin.psychologists.index')->with('error', 'User bukan psikolog.');
    }

    public function reject(User $psychologist)
    {
        if ($psychologist->role === 'psikolog') {
            $psychologist->psychologist_status = 'rejected';
            $psychologist->save();
            return redirect()->route('admin.psychologists.index')->with('success', 'Psikolog telah ditolak.');
        }
        return redirect()->route('admin.psychologists.index')->with('error', 'User bukan psikolog.');
    }
}