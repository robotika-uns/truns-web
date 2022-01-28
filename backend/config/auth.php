<?php

/**
 * -----------------------------------------------------------------------------
 * Auth Configuration
 * -----------------------------------------------------------------------------
 * 
 * Semua konfigurasi yang menyangkut otentikasi.
 * 
 */




return [

  /**
   * Cooldown untuk mengirim ulang email (dalam satuan detik).
   * 
   * default: 60 detik.
   * 
   */
  'resend_cooldown' => 60,


  /**
   * Limit untuk mengirim ulang email.
   * 
   * default: 5x.
   * 
   */
  'resend_limit' => 5,


  /**
   * Maksimal verifikasi email (dalam satuan detik).
   * 
   * default: 6 Jam.
   * 
   */
  'verify_expired'  => 60 * 60 * 6

];
