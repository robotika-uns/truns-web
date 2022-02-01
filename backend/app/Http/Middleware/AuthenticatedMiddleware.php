<?php

/**
 * -----------------------------------------------------------------------------
 * Authenticated Middleware 
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus sudah terverifikasi.
 * 
 */




namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Session;
use Illuminate\Support\Facades\Crypt;




class AuthenticatedMiddleware
{
  public function handle($request, Closure $next, $guard = null)
  {
    // Ambil session token dari Authorization Bearer Header.
    $encrypted_token = $request->bearerToken();

    // Jika Bearer token belum disertakan pada Authorization Header.
    if (!$encrypted_token) {
      return response()->json([
        'tag' => 'belum_terotentikasi',
        'pesan' => 'Kamu belum terotentikasi.'
      ], 401);
    }

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

    // Jika session ditemukan,
    $user = User::find($session->user_id);

    // Taruh data $user ke $request supaya dapat digunakan kembali.
    $request->auth = $user;
    $request->sessions = $session;


    // Teruskan ke route tujuan.
    return $next($request);
  }
}
