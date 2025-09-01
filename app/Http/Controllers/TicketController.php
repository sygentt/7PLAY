<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display user's tickets (active and history).
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Active tickets (confirmed orders with future showtimes)
        $activeTickets = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->where('status', Order::STATUS_CONFIRMED)
            ->whereHas('orderItems.showtime', function ($query) {
                $query->where('show_time', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Order history (all completed orders with past showtimes)
        $orderHistory = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }])
            ->where('status', Order::STATUS_CONFIRMED)
            ->whereHas('orderItems.showtime', function ($query) {
                $query->where('show_time', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'history_page');

        return view('profile.tickets', compact('activeTickets', 'orderHistory'));
    }
}
