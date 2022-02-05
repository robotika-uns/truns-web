<?php

/**
 * -----------------------------------------------------------------------------
 * Authenticated Unverified Email Middleware
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus belum terverifikasi.
 * 
 */




namespace App\Http\Middleware;

use Closure;




class UnverifiedEmailMiddleware
{
  public function handle($request, Closure $next, $guard = null)
  {

    // Jika email belum diverifikasi.
    if ($request->auth->email_verified == 'verified') {
      return response()->json([
        'tag' => 'email_sudah_diverifikasi',
        'pesan' => 'Email sudah diverifikasi.'
      ], 401);
    }

    // Teruskan ke route tujuan.
    return $next($request);
  }
}
