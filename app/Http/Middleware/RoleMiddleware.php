<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!in_array($user->role, $roles)) {
            // Redirect ke panel yang sesuai role user
            return redirect()->route('dashboard.redirect');
        }

        // Cek status aktif
        if ($user->status !== 'aktif') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'nip' => 'Akun kamu tidak aktif.',
            ]);
        }

        return $next($request);
    }
}