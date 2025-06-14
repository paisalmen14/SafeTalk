<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consultation;

class CancelExpiredReservations extends Command
{
    protected $signature = 'reservations:cancel-expired';
    protected $description = 'Cancel reservations that have not been paid within the time limit';

    public function handle(): void
    {
        $expiredConsultations = Consultation::where('status', 'pending_payment')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredConsultations as $consultation) {
            $consultation->status = 'expired';
            $consultation->save();
            // Opsional: Kirim notifikasi ke user bahwa reservasinya hangus
            // $consultation->user->notify(new ReservationExpiredNotification($consultation));
        }

        $this->info(count($expiredConsultations) . ' expired reservations have been cancelled.');
    }
}