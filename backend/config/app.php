<?php

/**
 * -----------------------------------------------------------------------------
 * App Configuration
 * -----------------------------------------------------------------------------
 * 
 * Semua konfigurasi yang menyangkut aplikasi.
 * 
 */




return [

    /**
     * Encryption Key
     * 
     * Key ini digunakan oleh layanan encrypter dan harus disetel menjadi
     * 32 karakter acak, jika tidak, string yang terenkripsi nantinya
     * tidak akan aman.
     * 
     */
    'key' => env('APP_KEY', 'SomeRandomString!'),

    'cipher' => 'AES-256-CBC',


    /**
     * Application Locale Configuration
     * 
     * Locale menentukan lokalisase bahasa default yang akan digunakan
     * oleh translation service provider. Atur nilai ini ke salah
     * satu lokalisasi yang akan didukung oleh aplikasi.
     * 
     */
    'locale' => env('APP_LOCALE', 'id'),


    /**
     * Application Fallback Locale
     * 
     * Fallback Locale menentukan lokalisasi yang akan digunakan saat yang sekarang
     * tidak tersedia.
     * 
     */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'id'),

];
