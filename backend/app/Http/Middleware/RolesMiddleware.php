<?php

/**
 * -----------------------------------------------------------------------------
 * Roles Middleware 
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan rolenya harus sesuai.
 * 
 */




namespace App\Http\Middleware;

use Closure;




class RolesMiddleware
{
    public function handle($request, Closure $next, $roles)
    {

        $user = $request->auth;
        $roles = explode("|", $roles);

        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request);
            }
        }

        return response()->json([
            'tag' => 'forbidden',
            'pesan' => 'Kamu tidak diizinkan mengakses ini.'
        ], 401);
    }
}
