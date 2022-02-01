<?php

/**
 * -----------------------------------------------------------------------------
 * Authenticated Verified Email Middleware 
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus sudah terverifikasi.
 * 
 */




namespace App\Http\Middleware;

use Closure;




class VerifiedEmailMiddleware
{
  public function handle($request, Closure $next, $guard = null)
  {

    // Jika email belum diverifikasi.
    if (!($request->auth->email_verified == 'verified')) {
      return response()->json([
        'tag' => 'email_belum_diverifikasi',
        'pesan' => 'Email belum diverifikasi.'
      ], 401);
    }

    // Teruskan ke route tujuan.
    return $next($request);
  }
}
