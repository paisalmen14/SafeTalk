<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isMember()) {
            // Redirect ke halaman membership jika bukan member
            return redirect()->route('membership.index')->with('error', 'Anda harus menjadi member untuk mengakses fitur ini.');
        }
        return $next($request);
    }
}