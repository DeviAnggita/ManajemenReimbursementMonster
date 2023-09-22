<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public const ROLE_SUPER_ADMIN = 1;
    public const ROLE_KEPALA_DIVISI = 2;
    public const ROLE_MANAJER_KEUANGAN = 3;
    public const ROLE_KARYAWAN = 4;
    public const ROLE_STAFF_KEUANGAN = 5;

    public function handle($request, Closure $next, $role)
    {
        // Memeriksa apakah pengguna memiliki peran yang sesuai
        if (Auth::user()->id_role != $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}