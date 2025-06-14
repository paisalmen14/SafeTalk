<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation;

class NavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $hasActiveConsultation = false;

        if (Auth::check() && Auth::user()->role === 'pengguna') {
            $hasActiveConsultation = Consultation::where('user_id', Auth::id())
                ->where('status', 'confirmed')
                ->whereRaw('DATE_ADD(requested_start_time, INTERVAL duration_minutes MINUTE) > ?', [now()])
                ->exists();
        }

        $view->with('hasActiveConsultation', $hasActiveConsultation);
    }
    }