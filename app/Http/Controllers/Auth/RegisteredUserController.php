<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', Rule::in(['pengguna', 'psikolog'])],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'psychologist_status' => $request->role === 'psikolog' ? 'pending' : null,
        ]);

        event(new Registered($user));

        // PENYESUAIAN LOGIKA SETELAH REGISTRASI
        if ($user->role === 'psikolog') {
            // Jika psikolog, jangan login, redirect ke halaman login dengan pesan
            return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda akan segera diverifikasi oleh Admin sebelum dapat digunakan.');
        }
        
        // Jika pengguna biasa, langsung login
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}