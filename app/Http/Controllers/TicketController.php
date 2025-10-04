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
            ->with(['orderItems.seat', 'orderItems.showtime' => function ($query) {
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
     * Tampilkan e-ticket untuk order item tertentu (per kursi).
     */
    public function showEticket(Request $request, $orderItem): View
    {
        $user = $request->user();
        
        // Load OrderItem with relations
        $orderItem = \App\Models\OrderItem::with([
            'seat',
            'order.user',
            'showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema.city']);
            }
        ])->findOrFail($orderItem);
        
        // Pastikan pengguna hanya bisa melihat e-ticket miliknya sendiri
        if ($orderItem->order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        // Pastikan pesanan sudah dibayar atau dikonfirmasi
        if (!in_array($orderItem->order->status, [Order::STATUS_PAID, Order::STATUS_CONFIRMED])) {
            abort(404, 'E-ticket not available for this order');
        }

        return view('profile.e-ticket', compact('orderItem'));
    }
}



