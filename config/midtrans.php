<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway integration.
    | Set these values in your .env file for security.
    |
    */

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans API URLs
    |--------------------------------------------------------------------------
    */
    'api_url' => [
        'sandbox' => 'https://api.sandbox.midtrans.com/v2',
        'production' => 'https://api.midtrans.com/v2',
    ],

    'snap_url' => [
        'sandbox' => 'https://app.sandbox.midtrans.com/snap/snap.js',
        'production' => 'https://app.midtrans.com/snap/snap.js',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Configuration
    |--------------------------------------------------------------------------
    */
    'qris' => [
        'validity_period_minutes' => 10, // 10 menit sesuai requirement UI
        'currency' => 'IDR',
    ],

    // SnapBI specific config (required for QRIS via SnapBI)
    'snapbi' => [
        'client_id' => env('MIDTRANS_SNAPBI_CLIENT_ID'),
        // Private key PEM content. On .env, store with literal \n or base64 and decode in service if needed
        'private_key' => env('MIDTRANS_SNAPBI_PRIVATE_KEY'),
        'client_secret' => env('MIDTRANS_SNAPBI_CLIENT_SECRET'),
        'partner_id' => env('MIDTRANS_SNAPBI_PARTNER_ID'),
        'channel_id' => env('MIDTRANS_SNAPBI_CHANNEL_ID', '7PLAY'),
        'enable_logging' => env('MIDTRANS_SNAPBI_ENABLE_LOGGING', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    */
    'webhook' => [
        'notification_url' => env('APP_URL') . '/api/midtrans/notification',
        // Optional: static callback token to validate Midtrans webhook (set in Midtrans dashboard)
        'callback_token' => env('MIDTRANS_CALLBACK_TOKEN'),
        // Optional: allowed IPs for webhook, leave empty to skip IP check
        'allowed_ips' => array_filter(array_map('trim', explode(',', (string) env('MIDTRANS_ALLOWED_IPS', '')))),
    ],

    /*
    |--------------------------------------------------------------------------
    | Enabled Payment Methods (UI)
    |--------------------------------------------------------------------------
    | Control which methods are shown/enabled on the frontend. By default only
    | QRIS is enabled. Add other methods when ready to implement.
    */
    'enabled_methods' => [
        'qris',
        // 'va', // bank_transfer (BCA/BNI/BRI/Mandiri/Permata)
        // 'ewallet', // gopay/ovo/dana/shopeepay
        // 'credit_card',
    ],
];
