<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QrVerificationController extends Controller
{
    /**
     * Verify QR code and display ticket information.
     */
    public function verify(Request $request, string $token): View
    {
        // Find order by QR token
        $order = Order::where('qr_code', $token)->first();
        
        if (!$order) {
            abort(404, 'QR Code tidak valid atau sudah kedaluwarsa');
        }
        
        // Load order with all related data
        $order->load([
            'orderItems.seat',
            'orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema.city']);
            },
            'user'
        ]);

        return view('qr.verification', compact('order'));
    }
}

