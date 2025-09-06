<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckinController extends Controller
{
    /**
     * Check-in by QR token (order.qr_code). Marks each seat once-used.
     */
    public function checkinByQr(Request $request): JsonResponse
    {
        $token = (string) $request->input('token');
        if ($token === '') {
            return response()->json(['success' => false, 'message' => 'Token QR wajib diisi'], 422);
        }

        $order = Order::where('qr_code', $token)->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'QR tidak valid'], 404);
        }

        if (!in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CONFIRMED], true)) {
            return response()->json(['success' => false, 'message' => 'Order belum valid untuk check-in'], 400);
        }

        // Prevent check-in for past showtime by large margin if needed (optional)
        // if ($order->showtime->show_time->lt(now()->subHours(4))) {
        //     return response()->json(['success' => false, 'message' => 'Tiket kedaluwarsa untuk check-in'], 400);
        // }

        $order->load(['orderItems.seat', 'showtime.movie', 'showtime.cinemaHall.cinema']);

        $updated = 0;
        foreach ($order->orderItems as $item) {
            if (!$item->checked_in) {
                $item->update(['checked_in' => true, 'checked_in_at' => now()]);
                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $updated > 0 ? 'Check-in berhasil' : 'Semua kursi telah check-in sebelumnya',
            'order_id' => $order->id,
            'checked_in_count' => $updated,
        ]);
    }
}


