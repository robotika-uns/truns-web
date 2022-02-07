<?php

/**
 * -----------------------------------------------------------------------------
 * Administrator Middleware 
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus sudah terverifikasi, serta mempunyai role sebagai
 * administrator.
 * 
 */




namespace App\Http\Middleware;

use Closure;




class AdminMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {

        // Jika email belum diverifikasi.
        if (!($request->auth->role == 'administrator')) {
            return response()->json([
                'tag' => 'tidak_diizinkan',
                'pesan' => 'Kamu tidak diizinkan.'
            ], 401);
        }

        // Teruskan ke route tujuan.
        return $next($request);
    }
}
