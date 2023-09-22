<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah pengguna sudah terautentikasi
        if (Auth::check()) {
            // Cek peran pengguna
            $user = Auth::user();
            $userRole = $user->role->nama_role;
            
            // Cek apakah peran pengguna sesuai dengan peran yang diperbolehkan
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        // Jika peran pengguna tidak sesuai atau pengguna belum terautentikasi, arahkan ke halaman login
        return redirect()->route('login');
    }
}