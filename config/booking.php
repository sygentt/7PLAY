<?php

return [
    // TTL terpusat untuk seluruh alur booking & pembayaran (menit)
    // Digunakan untuk: SeatReservation.expires_at, Order.expiry_date, Payment.expiry_time
    'ttl_minutes' => env('BOOKING_TTL_MINUTES', 10),
];


