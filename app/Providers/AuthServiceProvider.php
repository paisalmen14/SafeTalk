<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Story;
use App\Models\User;
use App\Models\Comment; 


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
        
    }
}
