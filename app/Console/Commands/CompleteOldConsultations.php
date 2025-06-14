<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consultation;

class CompleteOldConsultations extends Command
{
    protected $signature = 'consultations:complete-old';
    protected $description = 'Mark old, confirmed consultations as completed';

    public function handle(): void
    {
        $this->info('Mencari sesi konsultasi yang sudah selesai...');

        // Cari semua konsultasi yang statusnya 'confirmed'
        // dan waktu berakhirnya (mulai + durasi) sudah lewat dari sekarang.
        $completedConsultations = Consultation::where('status', 'confirmed')
            ->whereRaw('DATE_ADD(requested_start_time, INTERVAL duration_minutes MINUTE) <= ?', [now()])
            ->get();

        if ($completedConsultations->isEmpty()) {
            $this->info('Tidak ada sesi yang perlu diupdate.');
            return;
        }

        foreach ($completedConsultations as $consultation) {
            $consultation->status = 'completed';
            $consultation->save();
            $this->info("Sesi #{$consultation->id} telah ditandai sebagai 'completed'.");
        }

        $this->info('Proses selesai.');
    }
}