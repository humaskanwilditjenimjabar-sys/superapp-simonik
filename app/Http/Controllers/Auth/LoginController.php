<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip'      => ['required', 'digits:18'],
            'password' => ['required', 'string'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.digits'   => 'NIP harus 18 digit.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Rate limiting
        $key = 'login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'nip' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Attempt login dengan NIP
        $credentials = [
            'nip'      => $request->nip,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'nip' => 'NIP atau kata sandi salah.',
            ])->withInput($request->only('nip'));
        }

        RateLimiter::clear($key);

        $user = Auth::user();

        // Cek status akun
        if ($user->status === 'pending') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'nip' => 'Akun kamu sedang menunggu persetujuan admin.',
            ]);
        }

        if ($user->status === 'ditolak') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'nip' => 'Akun kamu telah ditolak. Hubungi administrator.',
            ]);
        }

        if ($user->status === 'nonaktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'nip' => 'Akun kamu telah dinonaktifkan. Hubungi administrator.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.redirect');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}