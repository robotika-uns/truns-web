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
   * Batas waktu verifikasi (dalam satuan detik).
   * 
   * default: 6 Jam.
   * 
   */
  'verify_max'  => 60 * 60 * 6,


  /**
   * Batas waktu kode verifikasi (dalam satuan detik).
   * 
   * default: 15 Menit.
   * 
   */
  'verify_kadaluarsa'  => 60 * 15

];
