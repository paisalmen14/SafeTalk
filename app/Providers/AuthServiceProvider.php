<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Story;
use App\Models\User;
use App\Models\Comment; 
use App\Models\Consultation;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate untuk mengizinkan penghapusan story
        Gate::define('delete-story', function (User $user, Story $story) {
            return $user->id === $story->user_id || $user->role === 'admin';
        });

        // Gate untuk mengizinkan pembaruan story
        Gate::define('update-story', function (User $user, Story $story) {
            return $user->id === $story->user_id && $story->created_at->diffInMinutes(now()) < 10;
        });

        // =======================================================
        // == TAMBAHKAN GATE UNTUK HAPUS KOMENTAR DI SINI ==
        // =======================================================
        Gate::define('delete-comment', function (User $user, Comment $comment) {
            // Izinkan jika user adalah pemilik komentar ATAU jika user adalah admin
            return $user->id === $comment->user_id || $user->role === 'admin';
        });

        Gate::define('access-consultation-chat', function (User $user, Consultation $consultation) {
            // 1. Pengguna harus merupakan peserta sesi (pasien atau psikolog).
            if ($user->id !== $consultation->user_id && $user->id !== $consultation->psychologist_id) {
                return false;
            }

            // 2. Status konsultasi harus sudah dikonfirmasi.
            if ($consultation->status !== 'confirmed') {
                return false;
            }

            // 3. Waktu saat ini harus berada dalam rentang jadwal DENGAN TOLERANSI.
            $startTime = $consultation->requested_start_time;
            $endTime = (clone $startTime)->addMinutes($consultation->duration_minutes);

            // Toleransi masuk: 5 menit SEBELUM jadwal
            $entryTime = (clone $startTime)->subMinutes(5);

            // Toleransi keluar: 5 menit SETELAH jadwal berakhir
            $exitTime = (clone $endTime)->addMinutes(5);
           

            // Pengecekan waktu baru dengan toleransi
            return now()->between($entryTime, $exitTime);
        });

        Gate::define('view-chat-history', function (User $user, Consultation $consultation) {
            // Aturan 1: Pengguna adalah peserta sesi
            if ($user->id !== $consultation->user_id && $user->id !== $consultation->psychologist_id) {
                return false;
            }

            // Aturan 2: Sesi sudah selesai atau dibatalkan setelah pembayaran
            return in_array($consultation->status, ['completed', 'payment_rejected', 'cancelled']);
        });
        
    }
}
