<?php

/**
 * -----------------------------------------------------------------------------
 * Log Localization
 * -----------------------------------------------------------------------------
 * 
 * Semua lokalisasi bahasa yang menyangkut log.
 * 
 */




return [

    'recruit'   => [
        'diterima'      => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>menerima</strong> pendaftaran rekrutmen <mention data-type="mention" data-id=":user" username=":user"></mention> dan ditempatkan pada Tim <strong>:Tim</strong> sebagai <strong>:Divisi</strong>.',
        'ditolak'       => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>menolak</strong> pendaftaran rekrutmen <mention data-type="mention" data-id=":user" username=":user"></mention>.',
        'finalisasi'    => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>memfinalisasi</strong> pendaftaran rekrutmen <strong>Batch :batch</strong>.',
    ],

    'user'   => [
        'tipe_changed'  => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>mengubah</strong> tipe <mention data-type="mention" data-id=":user" username=":user"></mention> menjadi <strong>:Tipe</strong>.',
        'role_changed'  => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>mengubah</strong> role <mention data-type="mention" data-id=":user" username=":user"></mention> menjadi <strong>:Role</strong>.',
    ],

    'journey'   => [
        'created'       => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>menambahkan</strong> journey Tim <strong>:Tim</strong> dan Divisi <strong>:Divisi</strong> pada <mention data-type="mention" data-id=":user" username=":user"></mention>.',
        'deleted'       => '<mention data-type="mention" data-id=":causer" username=":causer"></mention> <strong>menghapus</strong> journey Tim <strong>:Tim</strong> dan Divisi <strong>:Divisi</strong> dari <mention data-type="mention" data-id=":user" username=":user"></mention>.',
    ]

];
