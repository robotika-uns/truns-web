<?php

/**
 * -----------------------------------------------------------------------------
 * Unverified Email Middleware
 * -----------------------------------------------------------------------------
 * 
 * Semua route yang melewati middleware ini harus terotentikasi,
 * dan emailnya harus belum terverifikasi.
 * 
 */




namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Session;
use Illuminate\Support\Facades\Crypt;




class UnverifiedEmailMiddleware
{
  public function handle($request, Closure $next, $guard = null)
  {
    // Ambil session token dari Authorization Bearer Header.
    $encrypted_token = $request->bearerToken();

    // Jika Bearer token belum disertakan pada Authorization Header.
    if (!$encrypted_token) {
      return response()->json([
        'error' => 'authenticated_only',
        'message' => 'Kamu belum terotentikasi.'
      ], 401);
    }

    // Jika disertakan, mulai mencoba mendekripsi token.
    try {
      $token = Crypt::decrypt($encrypted_token);

      // Jika token ternyata tidak valid.
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
      return response()->json([
        'tag' => 'token_invalid',
        'message' => 'Sesion token tidak ditemukan atau sudah kadaluarsa.'
      ], 400);
    }

    // Jika token valid, cari session id token.
    $session = Session::find($token);

    // Jika session tidak ditemukan,
    if (!$session) {
      return response()->json([
        'error' => 'token_invalid',
        'message' => 'Sesion token tidak ditemukan atau sudah kadaluarsa.'
      ], 401);
    }

    // Jika session ditemukan,
    $user = User::find($session->user_id);

    // Jika email sudah diverifikasi.
    if ($user->email_verified == 'verified') {
      return response()->json([
        'error' => 'verified_email',
        'message' => 'Email sudah diverifikasi.'
      ], 401);
    }

    // Taruh data $user ke $request supaya dapat digunakan kembali.
    $request->auth = $user;
    $request->sessions = $session;


    // Teruskan ke route tujuan.
    return $next($request);
  }
}
