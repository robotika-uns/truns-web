<?php

/**
 * -----------------------------------------------------------------------------
 * Moderator Middleware 
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus sudah terverifikasi, serta mempunyai role sebagai
 * moderator.
 * 
 */




namespace App\Http\Middleware;

use Closure;




class ModeratorMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {

        if ($request->auth->role == 'administrator') {
            return $next($request);
        } else if ($request->auth->role == 'moderator') {
            return $next($request);
        }

        return response()->json([
            'tag' => 'tidak_diizinkan',
            'pesan' => 'Kamu tidak diizinkan.'
        ], 401);
    }
}
