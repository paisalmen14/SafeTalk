<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if ($request->has('notif_id') && auth()->check()) {
        $notification = auth()->user()->notifications()->find($request->notif_id);
        if ($notification) {
            $notification->markAsRead();
        }
    }
    return $next($request);
}
}
