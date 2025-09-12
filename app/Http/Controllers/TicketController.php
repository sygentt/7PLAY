<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
/**
     * Tampilkan tiket milik pengguna (aktif dan kedaluwarsa).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Tiket aktif: pesanan berstatus dibayar/dikonfirmasi dengan jadwal mendatang
        $activeTickets = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID])
            ->whereHas('orderItems.showtime', function ($query) {
                $query->upcoming();
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'active_page');

        // Tiket kedaluwarsa: pesanan berstatus dibayar/dikonfirmasi dengan jadwal yang sudah lewat
        $expiredTickets = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID])
            ->whereHas('orderItems.showtime', function ($query) {
                $query->past();
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'expired_page');

        return view('profile.tickets', compact('activeTickets', 'expiredTickets'));
    }

    /**
     * Tampilkan e-ticket untuk pesanan tertentu.
     */
    public function showEticket(Request $request, Order $order): View
    {
        $user = $request->user();
        
        // Pastikan pengguna hanya bisa melihat e-ticket miliknya sendiri
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        // Pastikan pesanan sudah dibayar atau dikonfirmasi
        if (!in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CONFIRMED])) {
            abort(404, 'E-ticket not available for this order');
        }
        
        // Muat pesanan beserta relasi yang dibutuhkan
        $order->load([
            'orderItems.seat',
            'orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema.city']);
            },
            'user'
        ]);

        return view('profile.e-ticket', compact('order'));
    }
}



