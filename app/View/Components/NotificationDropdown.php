<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotificationDropdown extends Component
{
    public $notifications;

    public function __construct()
    {
        $this->notifications = auth()->user() ? auth()->user()->unreadNotifications : collect();
    }

    public function render(): View|Closure|string
    {
        return view('components.notification-dropdown');
    }
}