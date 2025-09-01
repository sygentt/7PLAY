<?php

return [
    // Berapa rupiah untuk 1 poin (default: 10.000 = 1 poin)
    'earn_per_rupiah' => 10000,

    // Poin minimum per order yang disettle
    'min_per_order' => 1,

    // Kelipatan poin berdasarkan membership level
    'multipliers' => [
        'bronze' => 1.0,
        'silver' => 1.25,
        'diamond' => 1.5,
    ],

    // Threshold total poin untuk naik level (bronze adalah default)
    'thresholds' => [
        'silver' => 1000,
        'diamond' => 5000,
    ],
];


