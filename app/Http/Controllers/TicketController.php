<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
/**
     * Display user's tickets (active and expired).
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Active tickets (paid/confirmed orders with upcoming showtimes)
        $activeTickets = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID])
            ->whereHas('orderItems.showtime', function ($query) {
                $query->where('show_time', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'active_page');

        // Expired tickets (paid/confirmed orders with past showtimes)
        $expiredTickets = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID])
            ->whereHas('orderItems.showtime', function ($query) {
                $query->where('show_time', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'expired_page');

        return view('profile.tickets', compact('activeTickets', 'expiredTickets'));
    }

    /**
     * Display e-ticket for specific order.
     */
    public function showEticket(Request $request, Order $order): View
    {
        $user = $request->user();
        
        // Ensure user can only view their own e-tickets
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        // Ensure order is paid or confirmed
        if (!in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CONFIRMED])) {
            abort(404, 'E-ticket not available for this order');
        }
        
        // Load order with all related data
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



