<?php

/**
 * -----------------------------------------------------------------------------
 * Default Setting Configuration
 * -----------------------------------------------------------------------------
 * 
 * Nilai default untuk tabel settings.
 * 
 */




return [
    'recruit' => [

        'status'    => [
            'default'   => "0",
            'roles'     => ['administrator', 'moderator']
        ],

        'batch'     => [
            'default'   => "1",
            'roles'     => ['administrator', 'moderator']
        ]
    ]
];
