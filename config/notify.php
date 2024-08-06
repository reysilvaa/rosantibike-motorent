<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notify Theme
    |--------------------------------------------------------------------------
    |
    | You can change the theme of notifications by specifying the desired theme.
    | By default the theme light is activated, but you can change it by
    | specifying the dark mode. To change theme, update the global variable to `dark`
    |
    */

    'theme' => env('NOTIFY_THEME', 'light'),

    /*
    |--------------------------------------------------------------------------
    | Notification timeout
    |--------------------------------------------------------------------------
    |
    | Defines the number of seconds during which the notification will be visible.
    |
    */

    'timeout' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Preset Messages
    |--------------------------------------------------------------------------
    |
    | Define any preset messages here that can be reused.
    | Available model: connect, drake, emotify, smiley, toast
    |
    */

    'preset-messages' => [
        'success' => [
            'type' => 'success', // Warna hijau untuk sukses
            'title' => 'Sukses',
            'message' => 'Operasi berhasil dilakukan.',
            'icon' => 'check-circle', // Ikon untuk notifikasi sukses
            'model' => 'toast', // Optional, add if model is needed
        ],
        'error' => [
            'type' => 'error', // Warna merah untuk error
            'title' => 'Kesalahan',
            'message' => 'Terjadi kesalahan, coba lagi.',
            'icon' => 'x-circle', // Ikon untuk notifikasi error
            'model' => 'toast', // Optional, add if model is needed
        ],
        'info' => [
            'type' => 'info', // Warna biru untuk informasi
            'title' => 'Informasi',
            'message' => 'Ini adalah informasi penting.',
            'icon' => 'info', // Ikon untuk notifikasi informasi
            'model' => 'toast', // Optional, add if model is needed
        ],
        'warning' => [
            'type' => 'warning', // Warna kuning untuk peringatan
            'title' => 'Peringatan',
            'message' => 'Periksa kembali pengaturan Anda.',
            'icon' => 'exclamation-circle', // Ikon untuk notifikasi peringatan
            'model' => 'toast', // Optional, add if model is needed
        ],
        'common-notification' => [
            'type' => 'secondary', // Warna abu-abu untuk notifikasi umum
            'title' => 'Notifikasi',
            'message' => '',
            'model' => 'toast', // Optional, add if model is needed
            'icon' => 'bell', // Ikon untuk notifikasi umum
        ],
    ],
];
