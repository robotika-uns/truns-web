<?php

/**
 * -----------------------------------------------------------------------------
 * Guest Middleware
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus belum terotentikasi.
 * 
 */




namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Session;
use Illuminate\Support\Facades\Crypt;




class GuestMiddleware
{
  public function handle($request, Closure $next, $guard = null)
  {
    // Ambil session token dari Authorization Bearer Header.
    $encrypted_token = $request->bearerToken();

    if ($encrypted_token) {
      // Jika disertakan, mulai mencoba mendekripsi token.
      try {
        $token = Crypt::decrypt($encrypted_token);

        // Jika token ternyata tidak valid.
      } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return response()->json([
          'tag' => 'token_salah',
          'pesan' => 'Sesion token tidak ditemukan atau sudah kadaluarsa.'
        ], 400);
      }

      // Jika token valid, cari session id token.
      $session = Session::find($token);

      // Jika session tidak ditemukan,
      if (!$session) {
        return response()->json([
          'tag' => 'token_salah',
          'pesan' => 'Sesion token tidak ditemukan atau sudah kadaluarsa.'
        ], 401);
      }

      return response()->json([
        'tag' => 'sudah_terotentikasi',
        'pesan' => 'Kamu sudah terotentikasi.'
      ], 401);
    }


    // Teruskan ke route tujuan.
    return $next($request);
  }
}
